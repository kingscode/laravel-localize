<?php

declare(strict_types=1);

namespace KingsCode\LaravelLocalize;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Routing\UrlGenerator as UrlGeneratorContract;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator as BaseUrlGenerator;
use Illuminate\Support\ServiceProvider;

class LocalizeServiceProvider extends ServiceProvider
{
    /**
     * Boots the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . ' /../config/localize.php' => config_path('localize.php'),
        ], 'config');
    }

    /**
     * Registers the package's services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/localize.php', 'localize');

        $this->app->extend(UrlGeneratorContract::class, function (
            BaseUrlGenerator $urlGenerator,
            Container $container
        ) {
            return new UrlGenerator(
                $this->app->make(Router::class)->getRoutes(),
                $urlGenerator->getRequest(),
                $container->make(Repository::class)
            );
        });
    }
}
