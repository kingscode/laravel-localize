<?php

namespace KoenHoeijmakers\LaravelLocalize;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Routing\Router;

/**
 * @mixin \Illuminate\Foundation\Support\Providers\RouteServiceProvider
 */
trait RegistersLocalizedRoutes
{
    /**
     * Define the localized "web" routes for the application.
     *
     * @return void
     */
    protected function mapLocalizedWebRoutes()
    {
        $config = $this->app->make(Repository::class);
        $router = $this->app->make(Router::class);

        $router->middleware('web')
            ->namespace($this->namespace)
            ->group($config->get('localize.localized_routes_file'));

        $router->middleware('web')
            ->namespace($this->namespace)
            ->prefix('{' . $config->get('localize.route_parameter_key') . '}')
            ->name($config->get('localize.route_name_prefix') . '.')
            ->group($config->get('localize.localized_routes_file'));
    }
}
