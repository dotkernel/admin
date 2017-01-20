<?php

return [

    'dot_authorization' => [

        //define how it will treat non-matching guard rules, allow all by default
        'protection_policy' => \Dot\Rbac\Guard\GuardInterface::POLICY_DENY,

        //register custom guards providers here
        'guards_provider_manager' => [],

        //define custom guards here
        'guard_manager' => [],

        //list of guards
        'guards_provider' => [
            //the list of guards to use. Custom guards need to be registered in the guard manager first
            \Dot\Rbac\Guard\Provider\ArrayGuardsProvider::class => [

                \Dot\Rbac\Guard\Route\RouteGuard::class => [
                    'login' => ['*'],
                    'logout' => ['*'],
                ],

                \Dot\Rbac\Guard\Controller\ControllerPermissionGuard::class => [
                    [
                        'route' => 'user',
                        'actions' => [],
                        'permissions' => ['authenticated']
                    ],
                    [
                        'route' => 'user',
                        'actions' => ['register', 'forgot-password', 'reset-password', 'confirm-account'],
                        'permissions' => ['unauthenticated']
                    ],
                    [
                        'route' => 'user',
                        'actions' => ['add', 'edit', 'delete'],
                        'permissions' => [
                            'permissions' => ['superuser', 'admin-manager'],
                            'condition' => \Dot\Rbac\Guard\GuardInterface::CONDITION_OR,
                        ],
                    ],

                    [
                        'route' => 'dashboard',
                        'actions' => [],
                        'permissions' => ['authenticated']
                    ],

                    [
                        'route' => 'f_user',
                        'actions' => [],
                        'permissions' => [
                            'permissions' => ['superuser', 'admin'],
                            'condition' => \Dot\Rbac\Guard\GuardInterface::CONDITION_OR
                        ]
                    ],
                ],
            ]
        ],

        //enable wanted url appending, used in the redirect on forbidden handler for now
        'allow_redirect_param' => true,

        //the name of the query param appended for the wanted url
        'redirect_query_name' => 'redirect',

        //options for the redirect on forbidden handler
        'redirect_options' => [

            'enable' => false,

            'redirect_route' => ['name' => 'login', 'params' => []],

        ],

        //overwrite default messages
        //'messages_options' => [],
    ]
];
