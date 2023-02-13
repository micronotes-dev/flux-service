<?php

namespace Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeModels;

use Illuminate\Database\Eloquent\Model;

class Foo extends Model
{
    protected $guarded = [];

    protected static function boot(): void
    {
        parent::boot();

        static::observe(PreventModelEventsObserver::class);
    }
}
