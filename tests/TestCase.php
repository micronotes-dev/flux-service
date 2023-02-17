<?php

namespace Micronotes\Flux\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Micronotes\Flux\FluxServiceProvider;
use Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeDriver;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Micronotes\\Flux\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            FluxServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('flux.drivers', [
            'foo-driver' => FakeDriver::class,
        ]);

        /*
        $migration = include __DIR__.'/../database/migrations/create_flux_table.php.stub';
        $migration->up();
        */
    }
}
