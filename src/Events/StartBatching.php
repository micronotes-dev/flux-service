<?php

namespace Micronotes\Flux\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Micronotes\Flux\Concerns\Contracts\RowConverter;

class StartBatching
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
}
