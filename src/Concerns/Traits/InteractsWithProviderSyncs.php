<?php

namespace Micronotes\Flux\Concerns\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Micronotes\Flux\DataTransferObjects\Reference;

trait InteractsWithProviderSyncs
{
    public function getInternalReference(): Reference
    {
        return new Reference(reference: $this->getKey());
    }

    public function getExternalReference(): Reference
    {
        return new Reference(reference: $this->getRouteKey());
    }

    public function providerSynchronizations(): MorphMany
    {
        return $this->morphMany(config('flux.provider_sync_model'), 'model');
    }
}
