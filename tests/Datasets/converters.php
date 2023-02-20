<?php

dataset('foos', [
    [
        'reference' => \Illuminate\Support\Str::uuid()->toString(),
        'data' => [
            fake()->word => fake()->word,
        ],
    ],
    [
        'reference' => \Illuminate\Support\Str::uuid()->toString(),
        'data' => null,
    ],
]);
