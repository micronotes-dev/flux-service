<?php

namespace Micronotes\Flux;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use JetBrains\PhpStorm\Pure;
use Micronotes\Flux\Concerns\Contracts\FluxDriver;

class FluxExport
{
    public array $dispatchEvents = [
        'exporting' => \Micronotes\Flux\Events\Exporting::class,
    ];

    public readonly array $drivers;

    #[Pure] public function __construct(
        public readonly Collection $models,
        FluxDriver ...$drivers,
    )
    {
        $this->drivers = Arr::wrap($drivers);
    }
}
