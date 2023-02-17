<?php

namespace Micronotes\Flux\Concerns\Contracts;

use Micronotes\Flux\DataTransferObjects\UpsertableDto;

interface Upsertable
{
    public function getUpsertable(): UpsertableDto;
}
