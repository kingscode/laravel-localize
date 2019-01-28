<?php

namespace App\Http\Middleware;

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
        // The admin routes are excluded.
        if ($request->is($this->config->get(''))) {
            return $next($request);
        }

        // We don't have to do anything when the locale is null,
        // Given that our default locale is already set.
        if (null !== ($locale = $request->route('locale'))) {
            $this->config->set('app.locale', $locale);
        }

        return $next($request);
    }
}
