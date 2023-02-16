<?php

namespace Micronotes\Flux\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Micronotes\Flux\Models\ProviderSync;

class ProviderSyncCreating
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly ProviderSync $providerSync,
    )
    {
    }
}
