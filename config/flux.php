<?php

return [
    'provider_sync_model' => \Micronotes\Flux\Models\ProviderSync::class,

    'drivers' => [
        'firestore' => [
            'name' => 'Firebase Firestore',
            'driver' => 'class',
        ],
    ],
];
