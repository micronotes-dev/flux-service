<?php

namespace Micronotes\Flux\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Micronotes\Flux\Concerns\Contracts\RowConverter;

class Imported
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Model $model,
        public readonly ?RowConverter $converter = null,
    )
    {
    }
}
