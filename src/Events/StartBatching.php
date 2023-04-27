<?php

namespace Micronotes\Flux\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StartBatching
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
}
