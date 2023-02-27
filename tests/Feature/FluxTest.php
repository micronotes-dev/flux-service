<?php

use Illuminate\Support\Facades\Event;
use Micronotes\Flux\Facades\Flux;
use Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeModels\Foo;

it('can export data from driver', function (bool $batch) {
    $models = Foo::factory(random_int(5, 15))->make();

    $fluxExport = new \Micronotes\Flux\FluxExport(
        $models,
        \Micronotes\Flux\DriverFactory::make('foo-driver'),
    );

    Event::fake([
        \Micronotes\Flux\Events\StartBatching::class,
        \Micronotes\Flux\Events\Batched::class,
        \Micronotes\Flux\Events\Exporting::class,
        \Micronotes\Flux\Events\Exported::class,
        \Micronotes\Flux\Events\ExportFailed::class,
    ]);

    Flux::export($fluxExport, withBatch: $batch);

    $this->assertCount(0, $fluxExport->failed);
    $this->assertNotSame(0, $count = count($fluxExport->exported));
    $this->assertSame(count($fluxExport->converters), $count);

    if (!$batch) {
        Event::assertDispatchedTimes(
            \Micronotes\Flux\Events\Exporting::class,
            $count
        );
        Event::assertDispatchedTimes(
            \Micronotes\Flux\Events\Exported::class,
            $count
        );
    }
    Event::assertNotDispatched(\Micronotes\Flux\Events\ExportFailed::class);

    expect($fluxExport)
        ->getStatus()->toEqual(\Micronotes\Flux\Enums\FluxStatus::success)
        ->and($fluxExport)->exported->toHaveCount($count);
})->with([
    'batch:true' => ['batch' => true,],
    'batch:false' => ['batch' => false,],
]);

it('can import data from driver', function () {
    $driver = \Micronotes\Flux\DriverFactory::make('foo-driver');

    $fluxImport = new \Micronotes\Flux\FluxImport(
        (new Foo())->getMorphClass(),
        $driver,
        filters: [],
        dryRun: false,
    );

    Event::fake([
        \Micronotes\Flux\Events\Importing::class,
        \Micronotes\Flux\Events\Imported::class,
        \Micronotes\Flux\Events\ImportFailed::class,
    ]);

    \Micronotes\Flux\Facades\Flux::import($fluxImport);

    $this->assertNotSame(0, $count = count($fluxImport->retrievedConverters));

    Event::assertDispatchedTimes(
        \Micronotes\Flux\Events\Imported::class,
        $count
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
