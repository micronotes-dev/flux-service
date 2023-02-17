<?php

dataset('foos', [
    [
        'reference' => \Illuminate\Support\Str::uuid()->toString(),
        'data' => [
            fake()->randomKey => fake()->word,
        ],
    ],
    [
        'reference' => \Illuminate\Support\Str::uuid()->toString(),
        'data' => null,
    ],
]);
