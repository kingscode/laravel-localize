# Laravel Localize
[![Packagist](https://img.shields.io/packagist/v/kingscode/laravel-localize.svg?colorB=brightgreen)](https://packagist.org/packages/kingscode/laravel-localize)
[![Build Status](https://scrutinizer-ci.com/g/kingscode/laravel-localize/badges/build.png?b=master)](https://scrutinizer-ci.com/g/kingscode/laravel-localize/build-status/master) 
[![Code Coverage](https://scrutinizer-ci.com/g/kingscode/laravel-localize/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/kingscode/laravel-localize/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kingscode/laravel-localize/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kingscode/laravel-localize/?branch=master)
[![license](https://img.shields.io/github/license/kingscode/laravel-localize.svg?colorB=brightgreen)](https://github.com/kingscode/laravel-localize)
[![Packagist](https://img.shields.io/packagist/dt/kingscode/laravel-localize.svg?colorB=brightgreen)](https://packagist.org/packages/kingscode/laravel-localize)

An as minimalistic as possible localization package, makes it so the `app.locale` is set to `nl` in the case of `/nl/home`.

## Installation
Require the package.
```sh
composer require kingscode/laravel-localize
```

... and optionally publish the config.
```sh
php artisan vendor:publish --provider="KingsCode\LaravelLocalize\LocalizeServiceProvider"
```

Add the middleware to the needed middleware groups, in our case only to the *web* group.

```php
<?php

namespace App\Http;

class Kernel extends HttpKernel
{
    ...

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            ...
            LocaleSelector::class,     // <<<<<< Here it is.
            SubstituteBindings::class, // Its best to register before substitute bindings.
            ...
        ],
    ];
    
    ...
}
```

Now you must register the route file that holds your localized routes, you will do this twice: 
- Once without a prefix and prefixed name.
- Once with a prefix and prefixed name.

This makes it so that your default locale can use `/` instead of being forced to have `/en` when your website is english by default.

```php
<?php

use Illuminate\Contracts\Config\Repository;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Web routes without localization, like a "/file/{file}" route or such.
        $this->mapWebRoutes();
        
        // And as the last method call you'll do the localized web routes.
        $this->mapLocalizedWebRoutes();
    }
    
    /**
     * Define the localized "web" routes for the application.
     *
     * @return void
     */
    protected function mapLocalizedWebRoutes()
    {
        // We'll take stuff from the config to keep things easily configurable.
        // Not a must, but it prevents you from having to override stuff.
        $config = $this->app->make(Repository::class);
        
        // We'll need a router to register routes duh.
        $router = $this->app->make(Router::class);
        
        // Okay so here is an IMPORTANT part.
        // The normal routes, thus without prefix and prefixed name must be registered first.
        // If this is not the case then the prefix is going to catch all your routes like `/pizza`
        // Because `/{locale}` is registered before `/pizza`.
        $router->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/localized.web.php'));

        $router->middleware('web')
            ->namespace($this->namespace)
            // We add the prefix.
            ->prefix('{' . $config->get('localize.route_parameter_key') . '}')
            // And the name prefix.
            ->name($config->get('localize.route_name_prefix') . '.')
            ->group(base_path('routes/localized.web.php'));
    }
}
```
