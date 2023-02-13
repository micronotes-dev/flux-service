<?php

namespace Micronotes\Flux\Concerns;

use Micronotes\Flux\Concerns\Contracts\RowConverter;
use Micronotes\Flux\DataTransferObjects\Reference;

abstract class AbstractFluxRepository
{
    abstract public function updateOrCreate(RowConverter $converter);

    abstract public function get(Reference $converter): RowConverter;

    abstract public function delete(RowConverter $converter);
}
