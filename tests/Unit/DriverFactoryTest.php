<?php

use Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeDriver;

it('cannot create unknown flux driver', function () {
    $this->expectException(\LogicException::class);
    $this->expectExceptionMessage("Missing driver implementation for provider 'fake-driver'");

    app(\Micronotes\Flux\DriverFactory::class)->make('fake-driver');
});

it('can create a flux driver', function () {
    $driver = app(\Micronotes\Flux\DriverFactory::class)->make('foo-driver');

    expect($driver)
        ->toEqual(new FakeDriver())
        ->and(is_a($driver, \Micronotes\Flux\Concerns\Contracts\FluxDriver::class))
        ->toBeTrue();
});
