<?php

return [
    //this file contains some authorization example for default services
    //some example values are just virtual, and is not intended to work as-is
    //modify this file with actual values, according to your needs
    'dependencies' => [
        //maybe you want to change the place where the identity is retrieved
        //change this line and add you own IdentityProvider
        //default is AuthenticationIdentityProvider which gets the identity from th dot-authentication service.
        //IdentityProviderInterface::class => \Your\Identity\Provider,
    ],

    'dot_authorization' => [
        'assertion_map' => [
            //map permissions to assertions
            //'edit' => EditAssertion::class,
        ],

        'assertion_manager' => [],

        //name of the guest role to use if no identity is provided
        'guest_role' => 'guest',

        'role_provider_manager' => [],

        //example for a flat RBAC model using the InMemoryRoleProvider, hierarchical is also supported
        'role_provider' => [
            \Dot\Rbac\Role\Provider\InMemoryRoleProvider::class => [
                'superuser' => [
                    'permissions' => [
                        'superuser',
                        'authenticated'
                    ]
                ],
                'admin' => [
                    'permissions' => [
                        'admin',
                        'authenticated',
                    ]
                ],

                'guest' => [
                    'permissions' => [
                        'unauthenticated'
                    ]
                ]
            ]
        ],
    ]
];