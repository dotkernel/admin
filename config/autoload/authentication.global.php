<?php

use Admin\Admin\Entity\AdminEntity;
use Admin\Admin\Hydrator\AdminHydrator;
use Dot\User\Service\PasswordCheck;

return [
    'dot_authentication' => [
        'adapter' => [
            'type' => 'CallbackCheck',
            'options' => [
                'adapter' => 'database',

                'identity_prototype' => AdminEntity::class,
                'identity_hydrator' => AdminHydrator::class,

                'table' => 'admin',

                'identity_columns' => ['username', 'email'],
                'credential_column' => 'password',

                'callback_check' => PasswordCheck::class
            ]
        ],
        'storage' => [
            'type' => 'Session',
            'options' => [
                'namespace' => 'admin_authentication',
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
