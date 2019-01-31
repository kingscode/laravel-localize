<?php

namespace KingsCode\LaravelLocalize;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\UrlGenerationException;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\UrlGenerator as BaseUrlGenerator;
use Illuminate\Support\Arr;
use InvalidArgumentException;

class UrlGenerator extends BaseUrlGenerator
{
    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * UrlGenerator constructor.
     *
     * @param \Illuminate\Routing\RouteCollection     $routes
     * @param \Illuminate\Http\Request                $request
     * @param \Illuminate\Contracts\Config\Repository $config
     * @param string|null                             $assetRoot
     */
    public function __construct(
        RouteCollection $routes,
        Request $request,
        Repository $config,
        ?string $assetRoot = null
    ) {
        parent::__construct($routes, $request, $assetRoot);

        $this->config = $config;
    }

    /**
     * Get the URL to a named route.
     *
     * @param  string $name
     * @param  mixed  $parameters
     * @param  bool   $absolute
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function route($name, $parameters = [], $absolute = true)
    {
        try {
            return $this->getLocalizedRoute($name, Arr::wrap($parameters), $absolute);
        } catch (UrlGenerationException | InvalidArgumentException $exception) {
            //
        }

        return parent::route($name, $parameters, $absolute);
    }

    /**
     * @param string $name
     * @param array  $parameters
     * @param bool   $absolute
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function getLocalizedRoute(string $name, array $parameters = [], $absolute = true)
    {
        [$name, $parameters] = $this->getLocalizedNameAndParameters($name, $parameters);

        return parent::route($name, $parameters, $absolute);
    }

    /**
     * @param string $name
     * @param array  $parameters
     * @return array
     */
    protected function getLocalizedNameAndParameters(string $name, array $parameters): array
    {
        $currentLocale = $this->config->get('app.locale');

        if ($this->config->get('localize.default_locale') === $currentLocale) {
            return [
                $name,
                $parameters,
            ];
        }

        array_unshift($parameters, $currentLocale);

        return [
            $this->config->get('localize.route_name_prefix') . '.' . $name,
            $parameters,
        ];
    }
}
