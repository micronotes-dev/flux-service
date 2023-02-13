<?php

namespace Micronotes\Flux\Exceptions;

class FluxException extends \RuntimeException
{
    public static function missingMorphedModelFor(string $alias): self
    {
        return new self(
            __("No morphed class defined for alias '$alias'"),
        );
    }

    public static function missingMorphedModelConverterForDriver(string $alias, string $driver): self
    {
        return new self(
            __("No converter defined for morph alias '$alias' with driver '$driver'"),
        );
    }
}
