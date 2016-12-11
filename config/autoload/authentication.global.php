<?php

return [
    'dot_authentication' => [
        //required by the auth adapters, it may be optional for your custom adapters
        //specify the identity entity to use and its hydrator
        'identity_class' => \Dot\Admin\Entity\AdminEntity::class,
        'identity_hydrator_class' => \Dot\User\Entity\UserEntityHydrator::class,

        //this is adapter specific
        //currently we support HTTP basic and digest
        //below is config template for callbackcheck adapter which is for mysql
        'adapter' => [
            \Dot\Authentication\Adapter\DbTable\CallbackCheckAdapter::class => [
                //zend db adapter service name
                'db_adapter' => 'database',

                //your user table name
                'table_name' => 'admin',

                //what user fields should use for authentication(db fields)
                'identity_columns' => ['username', 'email'],

                //name of the password db field
                'credential_column' => 'password',

                'callback_check' => \Dot\User\Service\PasswordCheck::class,
            ],
        ],

        //storage specific options, example below, for session storage
        'storage' => [
            \Dot\Authentication\Storage\SessionStorage::class => [
                //session namespace
                'namespace' => 'admin_authentication',

                //what session member to use
                'member' => 'storage'
            ],
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