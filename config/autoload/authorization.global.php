<?php

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
                            'superuser',
                            'admin',
                            'authenticated',
                        ]
                    ],
                    'admin' => [
                        'permissions' => [
                            'admin',
                            'authenticated'
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
