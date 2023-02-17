<?php

use Micronotes\Flux\DataTransferObjects\Reference;
use Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeRowDataConverters\FooConverter;

it('can create a converter from data', function (string|int $reference, ?array $data) {
    $converter = FooConverter::fromProvider(
        reference: new Reference(id: $reference),
        data: $data,
    );

    expect($converter->toArray())
        ->toEqual([
            'reference' => $reference,
            'data' => $data,
            'foo' => 'baz',
        ]);
})->with('foos');
