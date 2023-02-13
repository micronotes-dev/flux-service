<?php

namespace Micronotes\Flux\DataTransferObjects;

class Reference
{
    public function __construct(
        public readonly null|int|string $reference,
    ) {
    }
}
