<?php

declare(strict_types=1);

namespace KingsCode\LaravelLocalize\Tests\Unit;

use  Illuminate\Contracts\Config\Repository as Config;
use KingsCode\LaravelLocalize\Localize;
use KingsCode\LaravelLocalize\Tests\TestCase;

class LocalizeTest extends TestCase
{
    private $languages = ['nl', 'en', 'de', 'es', 'it'];

    public function setUp(): void
    {
        parent::setUp();

        $config = $this->app->make(Config::class);

        $config->set('localize.route_prefix_options', $this->languages);
    }

    public function testGetLocalePrefixesReturnsCorrectArray()
    {
        $localize = $this->app->make(Localize::class);

        $result = $localize->getLocalePrefixes();

        $this->assertEquals($result, $this->languages);
    }
    
    /** @test */
    public function testGetRouteRegexReturnsCorrectRegex()
    {
        /** @var Localize $localize */
        $localize = $this->app->make(Localize::class);
        $expectedRegex = '^(nl|en|de|es|it)$';

        $result = $localize->getRouteRegex();

        $this->assertEquals($result, $expectedRegex);
    }
}
