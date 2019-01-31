<?php

namespace KoenHoeijmakers\LaravelLocalize\Tests\Feature;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Routing\Router;
use KoenHoeijmakers\LaravelLocalize\Middleware\LocaleSelector;
use KoenHoeijmakers\LaravelLocalize\Tests\TestCase;

class LocalizeTest extends TestCase
{
    /**
     * @var Router
     */
    protected $router;

    public function setUp()
    {
        parent::setUp();

        $this->router = $router = $this->app->make(Router::class);

        $router->middleware(LocaleSelector::class)->group(function (Router $router) {
            $router->get('home', function () {
                return 'non-localized';
            })->name('home');

            $this->router->get('{locale}/home', function () {
                return 'localized';
            })->name('localized.home');
        });
    }

    public function testLocaleIsSetWhenLocalizedRouteIsHit()
    {
        $response = $this->get('nl/home');

        $response->assertStatus(200)->assertSee('localized');

        $this->assertEquals('nl', $this->app->getLocale());
    }

    public function testLocaleIsDefaultWhenNonLocalizedRouteIsHit()
    {
        $response = $this->get('home');

        $response->assertStatus(200)->assertSee('non-localized');

        $this->assertEquals('en', $this->app->getLocale());
    }

    public function testRouteIsLocalizedWhenGeneratedInOtherLocale()
    {
        $this->app->setLocale('nl');

        /** @var UrlGenerator $urlGenerator */
        $urlGenerator = $this->app->make(UrlGenerator::class);

        $this->assertEquals('https://hoeijmakers.me/nl/home', $urlGenerator->route('home'));
    }

    public function testRouteIsNotLocalizedWhenGeneratedInDefaultLocale()
    {
        /** @var UrlGenerator $urlGenerator */
        $urlGenerator = $this->app->make(UrlGenerator::class);

        $this->assertEquals('https://hoeijmakers.me/home', $urlGenerator->route('home'));
    }

    public function testNormalRouteIsNotLocalized()
    {
        $this->app->setLocale('nl');

        $this->router->get('non-localized-route', function () {
            return 'wazza';
        })->name('non-localized-route');

        /** @var UrlGenerator $urlGenerator */
        $urlGenerator = $this->app->make(UrlGenerator::class);

        $this->assertEquals('https://hoeijmakers.me/non-localized-route', $urlGenerator->route('non-localized-route'));
    }
}
