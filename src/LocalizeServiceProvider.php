<?php

declare(strict_types=1);

namespace KoenHoeijmakers\LaravelLocalize;

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
    }
}
