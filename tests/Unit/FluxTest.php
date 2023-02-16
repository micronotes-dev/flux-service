<?php

use Micronotes\Flux\DataTransferObjects\Reference;
use Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeModels\Foo;
use Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeRowDataConverters\FooConverter;

it('can export data from driver', function() {
    $models = collect(new Foo());
    $fluxExport = new \Micronotes\Flux\FluxExport(
        $models,
        \Micronotes\Flux\DriverFactory::make('foo-driver'),
    );

    app(\Micronotes\Flux\Facades\Flux::class)->prepareExport($fluxExport);
});

it('can import data from driver', function() {
    $fluxImport = new \Micronotes\Flux\FluxImport(
        (new Foo())->getMorphClass(),
        \Micronotes\Flux\DriverFactory::make('foo-driver'),
    );

    app(\Micronotes\Flux\Facades\Flux::class)->prepareImport($fluxImport);
});
