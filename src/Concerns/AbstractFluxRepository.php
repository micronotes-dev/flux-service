<?php

namespace Micronotes\Flux\Concerns;

use Illuminate\Support\Enumerable;
use Micronotes\Flux\Concerns\Contracts\RowConverter;
use Micronotes\Flux\DataTransferObjects\Reference;

abstract class AbstractFluxRepository
{
    abstract public function search(?array $filters = []): Enumerable|iterable;

    abstract public function updateOrCreate(RowConverter $converter): RowConverter;

    abstract public function get(Reference $reference): RowConverter;

    abstract public function delete(RowConverter $converter): bool;
}
