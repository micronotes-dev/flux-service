<?php

namespace Micronotes\Flux\Concerns;

use Micronotes\Flux\Concerns\Contracts\RowConverter;
use Micronotes\Flux\DataTransferObjects\Reference;

abstract class AbstractFluxRepository
{
    abstract public function search(?array $filters = []): iterable;

    abstract public function updateOrCreate(iterable $converters): array;

    abstract public function get(Reference $reference): iterable;

    abstract public function delete(RowConverter $converter): bool;
}
