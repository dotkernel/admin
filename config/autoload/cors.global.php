<?php

declare(strict_types=1);

return [
    'cors' => [
        'origin' => ['*'],
        'methods' => ['DELETE', 'GET', 'OPTIONS', 'PATCH', 'POST', 'PUT'],
        'headers.allow' => ['Accept', 'Content-Type', 'Authorization'],
        'headers.expose' => [],
        'credentials' => false,
        'cache' => 0,
        'error' => [
            Frontend\App\Factory\CorsFactory::class, 'error'
        ]
    ],
];
