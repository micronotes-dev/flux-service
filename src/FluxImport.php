<?php

namespace Micronotes\Flux;

use Illuminate\Support\Enumerable;
use Micronotes\Flux\Concerns\Contracts\FluxDriver;
use Micronotes\Flux\Concerns\Contracts\RowConverter;
use Micronotes\Flux\Enums\FluxStatus;

class FluxImport
{
    public iterable|Enumerable $imported = [];

    public iterable $failed = [];

    /** @var RowConverter[] */
    public iterable $retrievedConverters = [];

    public Enums\FluxStatus $status = FluxStatus::waiting;

    public function __construct(
        public readonly string $modelAlias,
        public readonly FluxDriver $driver,
        // todo define authorized map string| filters for driver|converters
        public readonly ?array $filters = null,
        public readonly bool $dryRun = false,
    )
    {
    }
}
