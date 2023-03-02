<?php

namespace Micronotes\Flux;

use Illuminate\Database\Eloquent\Model;
use Micronotes\Flux\Concerns\Contracts\FluxDriver;
use Micronotes\Flux\Concerns\Contracts\RowConverter;
use Micronotes\Flux\DataTransferObjects\FailedFluxMessage;
use Micronotes\Flux\Enums\FluxStatus;

class FluxImport
{
    /** @var Model[] */
    public iterable $imported = [];

    /** @var FailedFluxMessage[] */
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
        public readonly ?\Closure $importUsing = null,
    ) {
    }
}
