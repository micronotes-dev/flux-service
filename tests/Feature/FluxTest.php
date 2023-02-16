<?php

use Illuminate\Support\Facades\Event;
use Micronotes\Flux\DataTransferObjects\Reference;
use Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeModels\Foo;
use Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeRowDataConverters\FooConverter;

it('can export data from driver', function() {
    $models = collect(new Foo());
    $fluxExport = new \Micronotes\Flux\FluxExport(
        $models,
        \Micronotes\Flux\DriverFactory::make('foo-driver'),
    );

    app('flux')->export($fluxExport);
    
    expect($fluxExport)->status->toEqual(\Micronotes\Flux\Enums\FluxStatus::success);
});

it('can import data from driver', function() {
    $driver = \Micronotes\Flux\DriverFactory::make('foo-driver');

    $fluxImport = new \Micronotes\Flux\FluxImport(
        (new Foo())->getMorphClass(),
        $driver,
        filters: [],
        dryRun: false,
    );

    $fluxImport->retrievedConverters = collect($driver?->getRepository()->search())->keyBy('reference.id');
    
    Event::fake([
        \Micronotes\Flux\Events\Importing::class,
        \Micronotes\Flux\Events\Imported::class,
        \Micronotes\Flux\Events\ImportFailed::class,
    ]);

    app('flux')->import($fluxImport);
    
    Event::assertDispatchedTimes(
        \Micronotes\Flux\Events\Imported::class,
        $count = count($fluxImport->retrievedConverters)
    );
    Event::assertDispatchedTimes(
        \Micronotes\Flux\Events\Importing::class,
        $count
    );
    Event::assertDispatchedTimes(
        \Micronotes\Flux\Events\ImportFailed::class,
        0
    );
    expect($fluxImport)
        ->status->toEqual(\Micronotes\Flux\Enums\FluxStatus::success)
        ->and($fluxImport)->imported->toHaveCount($count);
});
