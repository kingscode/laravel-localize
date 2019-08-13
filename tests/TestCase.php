<?php

declare(strict_types=1);

namespace KingsCode\LaravelLocalize\Tests;

use KingsCode\LaravelLocalize\LocalizeServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [LocalizeServiceProvider::class];
    }
}
