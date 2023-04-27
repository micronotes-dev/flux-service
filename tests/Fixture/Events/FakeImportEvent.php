<?php

namespace Micronotes\Flux\Tests\Fixture\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Micronotes\Flux\Concerns\Contracts\RowConverter;

class FakeImportEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly RowConverter $converter
    )
    {
    }
}
