<?php

namespace Micronotes\Flux\DataTransferObjects;

use Illuminate\Contracts\Support\Arrayable;

class UpsertableDto implements Arrayable
{
    public function __construct(
        public readonly string $morphClass,
        public readonly array $uniqueBy,
        public readonly array $attributes,
    ) {
    }

    public function toArray(): array
    {
        return [
            $this->attributes,
            $this->uniqueBy,
        ];
    }
}
