<?php

declare(strict_types=1);

return [
    'dot_navigation' => [
        //enable menu item active if any child is active
        'active_recursion' => true,
        'containers'       => [
            'main_menu'    => [
                'type'    => 'ArrayProvider',
                'options' => [
                    'items' => [
                        [
                            'options' => [
                                'label' => 'Dashboard',
                                'route' => [
                                    'route_name' => 'dashboard::dashboard-view',
                                ],
                                'icon'  => 'c-blue-500 fa fa-home',
                            ],
                        ],
                        [
                            'options' => [
                                'label' => 'Admin',
                                'route' => [],
                                'icon'  => 'c-teal-500 fa fa-user-secret',
                            ],
                            'pages'   => [
                                [
                                    'options' => [
                                        'label' => 'Admin accounts',
                                        'route' => [
                                            'route_name' => 'admin::admin-list',
                                        ],
                                    ],
                                ],
                                [
                                    'options' => [
                                        'label' => 'Login attempts',
                                        'route' => [
                                            'route_name' => 'admin::admin-login-list',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        [
                            'options' => [
                                'label' => 'User',
                                'route' => [],
                                'icon'  => 'c-teal-500 fa fa-user',
                            ],
                            'pages'   => [
                                [
                                    'options' => [
                                        'label' => 'User accounts',
                                        'route' => [
                                            'route_name' => 'user::user-list',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        [
                            'options' => [
                                'label' => 'Components',
                                'route' => [
                                    'route_name' => 'page::components',
                                ],
                                'icon'  => 'c-pink-500 fa fa-gears',
                            ],
                        ],
                    ],
                ],
            ],
            'account_menu' => [
                'type'    => 'ArrayProvider',
                'options' => [
                    'items' => [
                        [
                            'options' => [
                                'label' => 'Profile',
                                'route' => [
                                    'route_name' => 'admin::account-edit-form',
                                ],
                                'icon'  => 'ti-user',
                            ],
                        ],
                        [
                            'options' => [
                                'label' => 'Logout',
                                'route' => [
                                    'route_name' => 'admin::admin-logout',
                                ],
                                'icon'  => 'ti-power-off',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        //register custom providers here
        'provider_manager' => [],
    ],
];
