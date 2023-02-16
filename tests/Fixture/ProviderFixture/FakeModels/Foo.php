<?php

namespace Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeModels;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foo extends Model
{
    use HasUuids, HasFactory;

    protected $guarded = [];
    
    protected $primaryKey = 'uuid';
    
    protected $casts = [
        'data' => 'json',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::observe(PreventModelEventsObserver::class);
    }

    protected static function newFactory(): FooFactory
    {
        return new FooFactory();
    }
}
