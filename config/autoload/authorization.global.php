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
