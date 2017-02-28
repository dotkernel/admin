<?php

return [
    'dot_authorization' => [
        'protection_policy' => \Dot\Rbac\Guard\Guard\GuardInterface::POLICY_DENY,

        'event_listeners' => [],

        'guards_provider_manager' => [],
        'guard_manager' => [],

        'guards_provider' => [
            'type' => 'ArrayGuards',
            'options' => [
                'guards' => [
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
                                        'condition' => \Dot\Rbac\Guard\Guard\GuardInterface::CONDITION_OR,
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
                                        'condition' => \Dot\Rbac\Guard\Guard\GuardInterface::CONDITION_OR
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
