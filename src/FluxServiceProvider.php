<?php

namespace Micronotes\Flux;

use Micronotes\Flux\Commands\ExportFluxCommand;
use Micronotes\Flux\Commands\ImportFluxCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FluxServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('flux')
            ->hasConfigFile()
            ->hasMigration('create_flux_table')
            ->hasCommands([
                ImportFluxCommand::class,
                ExportFluxCommand::class,
            ])->runsMigrations();

        $this->app->bind(\Micronotes\Flux\Facades\Flux::class, Flux::class);
    }
}
