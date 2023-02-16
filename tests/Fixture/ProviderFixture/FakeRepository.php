<?php

namespace Micronotes\Flux\Tests\Fixture\ProviderFixture;

use Illuminate\Support\Enumerable;
use Illuminate\Support\Str;
use Micronotes\Flux\Concerns\AbstractFluxRepository;
use Micronotes\Flux\Concerns\Contracts\RowConverter;
use Micronotes\Flux\DataTransferObjects\Reference;
use Micronotes\Flux\Events\ProviderSyncCreated;
use Micronotes\Flux\Models\ProviderSync;
use Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeRowDataConverters\FooConverter;

class FakeRepository extends AbstractFluxRepository
{
    public function updateOrCreate(RowConverter $converter): RowConverter
    {
        event(new ProviderSyncCreated(new ProviderSync));

        return FooConverter::fromProvider(Reference::empty(), []);
    }

    public function get(Reference $reference): RowConverter
    {
        return FooConverter::fromProvider(Reference::generate(), []);
    }

    public function delete(RowConverter $converter): bool
    {
        return true;
    }

    public function search(?array $filters = []): iterable
    {
        return FooConverter::fromRows(
            collect(range(0, random_int(2, 15)))->map(fn() => [
                'uuid' => Str::uuid(),
                'data' => random_int(0, 1) ? [
                    fake()->word => fake()->randomElement([fake()->word, fake()->sentence, fake()->randomDigit()]),
                ] : null,
            ])->toArray()
        );
    }
}
