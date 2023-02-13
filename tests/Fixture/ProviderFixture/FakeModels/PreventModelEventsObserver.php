<?php

namespace Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeModels;

use Illuminate\Database\Eloquent\Model;

class PreventModelEventsObserver
{
    public function creating(Model $model): bool
    {
        return false;
    }

    public function updating(Model $model): bool
    {
        return false;
    }

    public function deleting(Model $model): bool
    {
        return false;
    }
}
