<?php

declare(strict_types=1);

use Dot\Rbac\Guard\Guard\GuardInterface;

return [
    'dot_authorization' => [
        'protection_policy'       => GuardInterface::POLICY_ALLOW,
        'event_listeners'         => [],
        'guards_provider_manager' => [],
        'guard_manager'           => [],
        'guards_provider'         => [
            'type'    => 'ArrayGuards',
            'options' => [
                'guards' => [
                    [
                        'type'    => 'ControllerPermission',
                        'options' => [
                            'rules' => [
                                [
                                    'route'       => 'admin',
                                    'actions'     => ['login'],
                                    'permissions' => ['*'],
                                ],
                                [
                                    'route'       => 'admin',
                                    'actions'     => [],
                                    'permissions' => ['authenticated'],
                                ],
                                [
                                    'route'       => 'dashboard',
                                    'actions'     => [],
                                    'permissions' => ['authenticated'],
                                ],
                                [
                                    'route'       => 'page',
                                    'actions'     => [],
                                    'permissions' => ['authenticated'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
