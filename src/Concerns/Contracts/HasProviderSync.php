<?php

namespace Micronotes\Flux\Concerns\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Micronotes\Flux\DataTransferObjects\Reference;

interface HasProviderSync
{
    public function getInternalReference(): Reference;

    public function getExternalReference(): Reference;

    public function providerSynchronizations(): MorphMany;
}
