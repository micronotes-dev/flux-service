<?php

namespace Micronotes\Flux\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Batched
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
}
