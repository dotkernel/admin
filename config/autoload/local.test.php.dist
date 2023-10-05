<?php

declare(strict_types=1);

use FrontendTest\Common\TestMode;

if (! TestMode::isEnabled()) {
    return [];
}

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'params' => [
                    'url' => 'sqlite:///:memory:',
                ],
            ],
        ],
    ],
];
