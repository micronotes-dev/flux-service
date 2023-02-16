<?php

namespace Micronotes\Flux;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use JetBrains\PhpStorm\Pure;
use Micronotes\Flux\Concerns\Contracts\FluxDriver;
use Micronotes\Flux\Concerns\Contracts\RowConverter;
use Micronotes\Flux\Enums\FluxStatus;

class FluxExport
{
    public readonly array $drivers;

    public iterable|Enumerable $exported = [];

    public iterable $failed = [];

    /** @var RowConverter[] */
    public iterable $converters = [];

    public Enums\FluxStatus $status = FluxStatus::waiting;

    #[Pure] public function __construct(
        public readonly Collection $models,
        FluxDriver ...$drivers,
    )
    {
        $this->drivers = Arr::wrap($drivers);
    }
}
