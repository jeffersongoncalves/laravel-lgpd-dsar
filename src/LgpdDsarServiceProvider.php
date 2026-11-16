<?php

namespace JeffersonGoncalves\LgpdDsar;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LgpdDsarServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-lgpd-dsar')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations();
    }
}
