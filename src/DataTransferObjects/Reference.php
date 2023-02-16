<?php

namespace Micronotes\Flux\DataTransferObjects;

use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;

class Reference
{
    public function __construct(
        public readonly null|int|string $id,
    ) {
    }

    #[Pure] public static function empty(): static
    {
        return new static(
            id: null,
        );
    }

    public static function generate(): static
    {
        return new static(
            id: Str::uuid(),
        );
    }
}
