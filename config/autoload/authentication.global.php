<?php

return [
    'dot_authentication' => [
        //required by the auth adapters, it may be optional for your custom adapters
        //specify the identity entity to use and its hydrator
        'identity_class' => \Dot\Admin\Admin\Entity\AdminEntity::class,
        'identity_hydrator_class' => \Dot\Admin\Admin\Entity\AdminEntityHydrator::class,

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

                'callback_check' => \Dot\User\Service\PasswordInterface::class,

                //your password checking callback, use a closure, a service name of a callable or a callable class name
                //we recommend using a service name or class name instead of closures, to be able to cache the config
                //the below closure is just an example, to show you the callable signature
                //'callback_check' => function($hash_passwd, $password) {
                //    return $hash_passwd === md5($password);
                //}
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