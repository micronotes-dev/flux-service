<?php

namespace Micronotes\Flux\Tests\Fixture\ProviderFixture;

use Micronotes\Flux\Concerns\AbstractFluxRepository;
use Micronotes\Flux\Concerns\Contracts\RowConverter;
use Micronotes\Flux\DataTransferObjects\Reference;
use Micronotes\Flux\Events\ProviderSyncCreated;
use Micronotes\Flux\Models\ProviderSync;
use Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeModels\Foo;
use Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeRowDataConverters\FooConverter;

class FakeRepository extends AbstractFluxRepository
{
    public function updateOrCreate(iterable $converters): array
    {
        $created = [];
        /** @var RowConverter $converter */
        foreach ($converters as $converter) {
            event(new ProviderSyncCreated(new ProviderSync));
            $reference = Reference::generate();
            $created[$reference->id()] = $converter->toArray();
        }

        return $created;
    }

    public function get(Reference $reference): iterable
    {
        return [];
    }

    public function delete(RowConverter $converter): bool
    {
        return true;
    }

    public function search(?array $filters = []): iterable
    {
        return FooConverter::fromRows(
            Foo::factory(random_int(1, 15))->make()->toArray()
        );
    }
}
