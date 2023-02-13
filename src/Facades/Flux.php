<?php

namespace Micronotes\Flux\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Micronotes\Flux\Flux
 */
class Flux extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Micronotes\Flux\Flux::class;
    }
}
