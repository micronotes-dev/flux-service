<?php

namespace Micronotes\Flux\Tests\Fixture\ProviderFixture\FakeModels;

use Illuminate\Database\Eloquent\Factories\Factory;

class FooFactory extends Factory
{
    protected $model = Foo::class;

    /**
     * {@inheritDoc}
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid,
            'data' => fake()->boolean ? [
                fake()->word => fake()->randomElement([fake()->word, fake()->sentence, fake()->randomDigit()]),
            ] : null,
            'foo' => fake()->word,
        ];
    }
}
