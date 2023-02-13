<?php

namespace Micronotes\Flux\Tests\Fixture\ProviderFixture;


use Micronotes\Flux\Concerns\AbstractFluxRepository;
use Micronotes\Flux\Concerns\Contracts\RowConverter;
use Micronotes\Flux\DataTransferObjects\Reference;

class FakeRepository extends AbstractFluxRepository
{
    public function updateOrCreate(RowConverter $converter): RowConverter
    {
        // TODO: Implement updateOrCreate() method.
    }

    public function get(Reference $reference): RowConverter
    {
        // TODO: Implement updateOrCreate() method.
    }

    public function delete(RowConverter $converter): bool
    {
        // TODO: Implement delete() method.
    }
}
