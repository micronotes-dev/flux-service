<?php

namespace Micronotes\Flux;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use JetBrains\PhpStorm\Pure;
use Micronotes\Flux\Concerns\Contracts\FluxDriver;
use Micronotes\Flux\Concerns\Contracts\RowConverter;
use Micronotes\Flux\Enums\FluxStatus;

class FluxExport
{
    public iterable|Enumerable $exported = [];

    public iterable $failed = [];

    /** @var RowConverter[] */
    public iterable $converters = [];

    /**
     * @param  Collection|Model[]  $models
     * @param  FluxDriver  $driver
     */
    #[Pure] public function __construct(
        public readonly array|Collection $models,
        public readonly FluxDriver $driver,
    )
    {
    }

    public function getStatus(): FluxStatus
    {
        if (empty($this->converters)) {
            return FluxStatus::waiting;
        }

        if (empty($this->failed) && !empty($this->exported)) {
            return FluxStatus::success;
        }

        if (!empty($this->failed) && !empty($this->exported)) {
            return FluxStatus::partial;
        }

        return FluxStatus::failed;
    }
}
