<?php

namespace KoenHoeijmakers\LaravelLocalize\Middleware;

use Closure;
use Illuminate\Contracts\Config\Repository;

class LocaleSelector
{
    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * LocaleSelector constructor.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
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
        // We don't have to do anything when the locale is null,
        // Given that our default locale is already set.
        if (null !== ($locale = $request->route($this->config->get('localize.route_parameter_key')))) {
            $this->config->set('app.locale', $locale);
        }

        return $next($request);
    }
}
