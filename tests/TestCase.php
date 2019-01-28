<?php

declare(strict_types=1);

namespace KoenHoeijmakers\LaravelLocalize\Tests;

use KoenHoeijmakers\LaravelLocalize\LocalizeServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp()
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [LocalizeServiceProvider::class];
    }
}
