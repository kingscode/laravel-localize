<?php


namespace KingsCode\LaravelLocalize;

use Illuminate\Contracts\Config\Repository;

class Localize
{
    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Get all the available locale.
     *
     * @return array
     */
    public function getLocalePrefixes(): array
    {
        return $this->config->get('localize.route_prefix_options', []);
    }

    /**
     * Generate regex that is used in the where to select {locale}.
     *
     * @return string
     */
    public function getRouteRegex(): string
    {
        $options = implode('|', array_filter($this->getLocalePrefixes() ?? []));
        return "^($options)$";
    }

    /**
     * @param Request|null $request
     * @return mixed
     */
    public function getLocaleFromRequest(Request $request = null)
    {
        if ($request === null) {
            $request = request();
        }

        return $request->route()->originalParameter(
            $this->config->get('lovalize.route_parameter_key', 'locale')
        );
    }
}