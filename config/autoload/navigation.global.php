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
                                'uri'   => '/',
                                'route' => [
                                    'route_name' => 'dashboard',
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
                                        'uri'   => '/admin/list',
                                    ],
                                ],
                                [
                                    'options' => [
                                        'label' => 'Logins',
                                        'uri'   => '/admin/logins',
                                    ],
                                ],
                            ],
                        ],
                        [
                            'options' => [
                                'label' => 'Components',
                                'uri'   => '/page/components',
                                'route' => [
                                    'route_name' => 'page',
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
                                    'route_name'   => 'admin',
                                    'route_params' => [
                                        'action' => 'account',
                                    ],
                                ],
                                'icon'  => 'ti-user',
                            ],
                        ],
                        [
                            'options' => [
                                'label' => 'Logout',
                                'route' => [
                                    'route_name'   => 'admin',
                                    'route_params' => [
                                        'action' => 'logout',
                                    ],
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
