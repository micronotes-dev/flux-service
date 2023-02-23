<?php

namespace Micronotes\Flux\DataTransferObjects;

use Illuminate\Support\Str;
use JetBrains\PhpStorm\Internal\TentativeType;
use JsonSerializable;

class Reference implements JsonSerializable
{
    public function __construct(
        public readonly null|int|string $id,
    ) {
    }

    public function id(): null|int|string
    {
        return $this->id;
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

    public function jsonSerialize(): string|int|null
    {
        return $this->id();
    }
}
