<?php

namespace Micronotes\Flux\DataTransferObjects;

use Micronotes\Flux\Concerns\Contracts\RowConverter;

class FailedFluxMessage
{
    public function __construct(
        public readonly Reference $reference,
        public readonly string $message,
    )
    {
    }
}
