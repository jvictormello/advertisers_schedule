<?php

return [
    'defaults' => [
        'attempts_threshold' => 3,
        'attempts_ttl' => 60,
        'failure_ttl' => 300
    ],

    'services' => [
        'brasilapi' => [
            'attempts_threshold' => 2,
            'attempts_ttl' => 1,
            'failure_ttl' => 600
        ]
    ]
];
