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
                        'type'    => 'RoutePermission',
                        'options' => [
                            'rules' => [
                                'admin::admin-login-form'        => ['unauthenticated'],
                                'admin::admin-login'             => ['unauthenticated'],
                                'admin::admin-create-form'       => ['authenticated'],
                                'admin::admin-create'            => ['authenticated'],
                                'admin::admin-delete-form'       => ['authenticated'],
                                'admin::admin-delete'            => ['authenticated'],
                                'admin::admin-edit-form'         => ['authenticated'],
                                'admin::admin-edit'              => ['authenticated'],
                                'admin::admin-list'              => ['authenticated'],
                                'admin::admin-login-list'        => ['authenticated'],
                                'admin::account-change-password' => ['authenticated'],
                                'admin::account-edit-form'       => ['authenticated'],
                                'admin::account-edit'            => ['authenticated'],
                                'admin::admin-logout'            => ['authenticated'],
                                'app::index-redirect'            => ['authenticated'],
                                'dashboard::dashboard-view'      => ['authenticated'],
                                'page::components'               => ['authenticated'],
                                'setting::setting-store'         => ['authenticated'],
                                'setting::setting-view'          => ['authenticated'],
                                'user::user-create-form'         => ['authenticated'],
                                'user::user-create'              => ['authenticated'],
                                'user::user-edit-form'           => ['authenticated'],
                                'user::user-edit'                => ['authenticated'],
                                'user::user-delete-form'         => ['authenticated'],
                                'user::user-delete'              => ['authenticated'],
                                'user::user-list'                => ['authenticated'],
                                'user::user-avatar-edit'         => ['authenticated'],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
