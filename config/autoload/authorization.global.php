<?php

declare(strict_types=1);

return [
    'dependencies' => [],
    'dot_authorization' => [
        'guest_role' => 'guest',

        'role_provider_manager' => [],

        'role_provider' => [
            'type' => 'InMemory',
            'options' => [
                'roles' => [
                    'superuser' => [
                        'permissions' => [
                            'authenticated',
                            'premium'
                        ]
                    ],
                    'admin' => [
                        'permissions' => [
                            'authenticated',
                            'premium'
                        ]
                    ],
                    'user' => [
                        'permissions' => [
                            'authenticated',
                            'premium'
                        ]
                    ],
                    'guest' => [
                        'permissions' => [
                            'unauthenticated',
                        ]
                    ]
                ]
            ]
        ],

        'assertion_manager' => [],
        'assertions' => []
    ]
];
