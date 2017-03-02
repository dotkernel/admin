<?php

return [
    'dot_authentication' => [
        'adapter' => [
            'type' => 'CallbackCheck',
            'options' => [
                'adapter' => 'database',

                'identity_prototype' => \Admin\Admin\Entity\AdminEntity::class,
                'identity_hydrator' => \Dot\Hydrator\ClassMethodsCamelCase::class,

                'table' => 'admin',

                'identity_columns' => ['username', 'email'],
                'credential_column' => 'password',

                'callback_check' => \Dot\User\Service\PasswordCheck::class
            ]
        ],
        'storage' => [
            'type' => 'Session',
            'options' => [
                'namespace' => 'frontend_authentication',
                'member' => 'storage',
            ]
        ],

        'adapter_manager' => [
            //register custom adapters here, like you would do in a normal container
        ],

        'storage_manager' => [
            //register custom storage adapters
        ],

        'resolver_manager' => [
            //define custom http authentication resolvers here
        ]
    ]
];
