<?php

declare(strict_types=1);

namespace KingsCode\LaravelLocalize\Middleware;

use Closure;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Translation\Translator;

class LocaleSelector
{
    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @var \Illuminate\Contracts\Translation\Translator
     */
    protected $translator;

    /**
     * LocaleSelector constructor.
     *
     * @param \Illuminate\Contracts\Config\Repository      $config
     * @param \Illuminate\Contracts\Translation\Translator $translator
     */
    public function __construct(Repository $config, Translator $translator)
    {
        $this->config = $config;
        $this->translator = $translator;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $parameterKey = $this->config->get('localize.route_parameter_key');

        // We don't have to do anything when the locale is null,
        // Given that our default locale is already set.
        if (null !== ($locale = $request->route()->parameter($parameterKey))) {
            $this->config->set('app.locale', $locale);

            $this->translator->setLocale($locale);
        }

        if ($this->config->get('localize.route_forget_parameter') === true) {
            $request->route()->forgetParameter($parameterKey);
        }

        return $next($request);
    }
}
