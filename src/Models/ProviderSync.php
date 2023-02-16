<?php

namespace Micronotes\Flux\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Micronotes\Flux\Enums\FluxType;
use Micronotes\Flux\Events\ProviderSyncCreated;
use Micronotes\Flux\Events\ProviderSyncCreating;

class ProviderSync extends Model
{
    protected $fillable = [
        'model_type',
        'model_id',
        'provider_type',
        'provider_id',
        'flux_type',
        'document',
    ];

    protected $casts = [
        'flux_type' => FluxType::class,
        'document' => 'array',
    ];

    protected $dispatchesEvents = [
        'creating' => ProviderSyncCreating::class,
        'created' => ProviderSyncCreated::class,
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
