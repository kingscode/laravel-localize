<?php

namespace KingsCode\LaravelLocalize\Tests\Feature;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Routing\Router;
use KingsCode\LaravelLocalize\Middleware\LocaleSelector;
use KingsCode\LaravelLocalize\Tests\TestCase;

class LocalizeTest extends TestCase
{
    /**
     * @var Router
     */
    protected $router;

    public function setUp(): void
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

        $this->assertSame('nl', $this->app->getLocale());
    }

    public function testTranslatorLocaleIsSetWhenLocalizedRouteIsHit()
    {
        $currentTranslatorLocale = $this->app->make('translator')->getLocale();

        $this->get('nl/home');

        $newTranslatorLocale = $this->app->make('translator')->getLocale();

        $this->assertNotSame($currentTranslatorLocale, $newTranslatorLocale);
        $this->assertSame('nl', $newTranslatorLocale);
    }

    public function testLocaleIsDefaultWhenNonLocalizedRouteIsHit()
    {
        $response = $this->get('home');

        $response->assertStatus(200)->assertSee('non-localized');

        $this->assertSame('en', $this->app->getLocale());
    }

    public function testRouteIsLocalizedWhenGeneratedInOtherLocale()
    {
        $this->app->setLocale('nl');

        /** @var UrlGenerator $urlGenerator */
        $urlGenerator = $this->app->make(UrlGenerator::class);

        $this->assertSame('https://kingscode.nl/nl/home', $urlGenerator->route('home'));
    }

    public function testRouteIsNotLocalizedWhenGeneratedInDefaultLocale()
    {
        /** @var UrlGenerator $urlGenerator */
        $urlGenerator = $this->app->make(UrlGenerator::class);

        $this->assertSame('https://kingscode.nl/home', $urlGenerator->route('home'));
    }

    public function testNormalRouteIsNotLocalized()
    {
        $this->app->setLocale('nl');

        $this->router->get('non-localized-route', function () {
            return 'wazza';
        })->name('non-localized-route');

        /** @var UrlGenerator $urlGenerator */
        $urlGenerator = $this->app->make(UrlGenerator::class);

        $this->assertSame('https://kingscode.nl/non-localized-route', $urlGenerator->route('non-localized-route'));
    }
}
