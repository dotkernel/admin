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
                                'icon'  => 'c-blue-500 ti-home',
                            ],
                        ],
                        [
                            'options' => [
                                'label' => 'Manage admins',
                                'route' => [],
                                'icon'  => 'c-teal-500 ti-view-list-alt ',
                            ],
                            'pages'   => [
                                [
                                    'options' => [
                                        'label' => 'Admins',
                                        'route' => [
                                            'route_name' => 'admin::admin-list',
                                        ],
                                    ],
                                ],
                                [
                                    'options' => [
                                        'label' => 'Logins',
                                        'route' => [
                                            'route_name' => 'admin::admin-login-list',
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
                                'icon'  => 'c-pink-500 ti-palette',
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
