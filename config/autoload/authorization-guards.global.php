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
                                'admin::login-admin-form'        => [],
                                'admin::login-admin'             => [],
                                'admin::create-admin-form'       => ['authenticated'],
                                'admin::create-admin'            => ['authenticated'],
                                'admin::delete-admin-form'       => ['authenticated'],
                                'admin::delete-admin'            => ['authenticated'],
                                'admin::edit-admin-form'         => ['authenticated'],
                                'admin::edit-admin'              => ['authenticated'],
                                'admin::list-admin'              => ['authenticated'],
                                'admin::list-admin-login'        => ['authenticated'],
                                'admin::change-account-password' => ['authenticated'],
                                'admin::edit-account-form'       => ['authenticated'],
                                'admin::edit-account'            => ['authenticated'],
                                'admin::logout-admin'            => ['authenticated'],
                                'app::index-redirect'            => ['authenticated'],
                                'dashboard::view-dashboard'      => ['authenticated'],
                                'page::components'               => ['authenticated'],
                                'setting::store-setting'         => ['authenticated'],
                                'setting::view-setting'          => ['authenticated'],
                                'user::create-user-form'         => ['authenticated'],
                                'user::create-user'              => ['authenticated'],
                                'user::edit-user-form'           => ['authenticated'],
                                'user::edit-user'                => ['authenticated'],
                                'user::delete-user-form'         => ['authenticated'],
                                'user::delete-user'              => ['authenticated'],
                                'user::list-user'                => ['authenticated'],
                                'user::edit-user-avatar'         => ['authenticated'],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
