<?php


namespace KingsCode\LaravelLocalize\Tests\Unit;

use  Illuminate\Contracts\Config\Repository as Config;
use KingsCode\LaravelLocalize\Localize;

class LocalizeTest
{
    private $languages = ['nl', 'en', 'de', 'es', 'it'];

    public function setUp()
    {
        $config = $this->app->make(Config::class);
        $config->set('localize.route_prefix_options', $this->languages);
    }
    
    /** @test */
    public function get_locale_prefixes_returns_correct_array()
    {
        //Arrange
        $localize = $this->app->make(Localize::class);
        
        //Act
        $result = $localize->getLocalePrefixes();
        
        //Assert
        $result->assertEqual($result, $this->languages);
    }
    
    /** @test */
    public function get_route_regex_returns_correct_regex()
    {
        //Arrange
        $localize = $this->app->make(Localize::class);
        $expectedRegex = '^(nl|en|de|es|it)$';

        //Act
        $result = $localize->getRouteRegex();

        //Assert
        $result->assertEqual($result, $expectedRegex);
    }
}