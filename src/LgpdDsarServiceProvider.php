<?php

namespace JeffersonGoncalves\LgpdDsar;

use JeffersonGoncalves\LgpdDsar\Commands\OverdueCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LgpdDsarServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('lgpd-dsar')
            ->hasConfigFile()
            ->hasMigrations(['create_lgpd_dsar_requests_table'])
            ->hasCommand(OverdueCommand::class);
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(DsarManager::class);
    }
}
