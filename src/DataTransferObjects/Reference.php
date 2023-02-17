<?php

namespace Micronotes\Flux\DataTransferObjects;

use Illuminate\Support\Str;

class Reference
{
    public function __construct(
        public readonly null|int|string $id,
    ) {
    }

     public static function empty(): self
     {
         return new self(
             id: null,
         );
     }

    public static function generate(): self
    {
        return new self(
            id: Str::uuid(),
        );
    }
}
