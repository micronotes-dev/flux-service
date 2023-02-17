<?php

namespace Micronotes\Flux\DataTransferObjects;

class FailedFluxMessage
{
    public function __construct(
        public readonly Reference $reference,
        public readonly string $message,
    ) {
    }
}
