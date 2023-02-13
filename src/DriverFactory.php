<?php

namespace Micronotes\Flux;

use Micronotes\Flux\Concerns\Contracts\FluxDriver;

class DriverFactory
{
    public static function make(string $provider): ?FluxDriver
    {
        $driverConfig = config('flux.drivers', []);

        if (!is_a($driverConfig[$provider] ?? null, FluxDriver::class, allow_string: true)) {
            throw new \LogicException("Missing driver implementation for provider '$provider'");
        }

        return app($driverConfig[$provider]);
    }
}
