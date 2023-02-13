<?php

namespace Micronotes\Flux\Concerns\Contracts;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Micronotes\Flux\DataTransferObjects\Reference;

interface RowConverter extends Arrayable
{
    public static function fromRows(array $providerRows): iterable;

    public static function fromProvider(Reference $reference, array $data): self;

    public function toProvider(): array;

    public function toQuery(): ?Builder;

    public static function empty(array $extra = []): array;
}