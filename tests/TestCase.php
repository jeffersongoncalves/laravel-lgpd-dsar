<?php

namespace JeffersonGoncalves\LgpdDsar\Tests;

use JeffersonGoncalves\LgpdDsar\LgpdDsarServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LgpdDsarServiceProvider::class,
        ];
    }
}
