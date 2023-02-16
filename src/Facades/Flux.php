<?php

namespace Micronotes\Flux\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void export
 * @method static void import
 * @method static void persisImport
 *
 * @see \Micronotes\Flux\Flux
 */
class Flux extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'flux';
    }
}
