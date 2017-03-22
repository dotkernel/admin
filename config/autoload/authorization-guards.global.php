<?php

use Dot\Rbac\Guard\Guard\GuardInterface;

return [
    'dot_authorization' => [
        'protection_policy' => GuardInterface::POLICY_DENY,

        'event_listeners' => [],

        'guards_provider_manager' => [],
        'guard_manager' => [],

        'guards_provider' => [
            'type' => 'ArrayGuards',
            'options' => [
                'guards' => [
                    [
                        'type' => 'Route',
                        'options' => [
                            'rules' => [
                                'login' => ['*'],
                                'logout' => ['*']
                            ]
                        ]
                    ],
                    [
                        'type' => 'Controller',
                        'options' => [
                            'rules' => [
                                [
                                    'route' => 'user',
                                    'actions' => [
                                        'register',
                                        'reset-password',
                                        'forgot-password',
                                        'confirm-account',
                                        'opt-out'
                                    ],
                                    // no restriction on these actions because they handle the authentication check
                                    'roles' => ['*'],
                                ]
                            ]
                        ]
                    ],
                    [
                        'type' => 'ControllerPermission',
                        'options' => [
                            'rules' => [
                                [
                                    'route' => 'user',
                                    'actions' => [],
                                    'permissions' => ['authenticated']
                                ],
                                [
                                    'route' => 'user',
                                    'actions' => ['add', 'edit', 'delete'],
                                    'permissions' => [
                                        'permissions' => ['superuser', 'admin-manager'],
                                        'condition' => GuardInterface::CONDITION_OR,
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
                                        'condition' => GuardInterface::CONDITION_OR
                                    ]
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ],
    ]
];
