<?php

namespace Micronotes\Flux\Facades;

use Illuminate\Support\Facades\Facade;
use Micronotes\Flux\Concerns\AbstractFluxRepository;
use Micronotes\Flux\FluxExport;
use Micronotes\Flux\FluxImport;

/**
 * @method static void export(FluxExport $fluxExport, ?AbstractFluxRepository $customRepository = null, ?bool $withBatch = false)
 * @method static void import(FluxImport $fluxImport)
 * @method static void persisImport(FluxImport $fluxImport)
 *
 * @see \Micronotes\Flux\Flux
 */
class Flux extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Micronotes\Flux\Flux::class;
    }
}
