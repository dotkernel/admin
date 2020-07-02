<?php

return [
    'dot_navigation' => [

        //enable menu item active if any child is active
        'active_recursion' => true,

        'containers' => [
            'main_menu' => [
                'type' => 'ArrayProvider',
                'options' => [
                    'items' => [
                        [
                            'options' => [
                                'label' => 'Dashboard',
                                'route' => [
                                    'route_name' => 'dashboard',
                                ],
                                'icon' => 'fa fa-tachometer',
                            ]
                        ],
                        [
                            'options' => [
                                'label' => 'Manage admins',
                                'route' => [
                                    'route_name' => 'admin',
                                    'route_params' => ['action' => 'manage']
                                ],
                                'icon' => 'fa fa-user-circle-o',
                            ]
                        ],
                        [
                            'options' => [
                                'label' => 'Manage users',
                                'route' => [
                                    'route_name' => 'dashboard',
                                    'route_params' => ['action' => 'manage']
                                ],
                                'icon' => 'fa fa-user-o',
                            ],
                        ],
                        [
                            'options' => [
                                'label' => 'Submenu 1',
                                'route' => '',
                                'icon' => 'fa fa-cog',
                            ],
                            'pages' => [
                                [
                                    'options' => [
                                        'label' => 'Submenu link 1',
                                        'uri' => '#',
                                        'icon' => 'fa fa-square',
                                    ],
                                ],
                                [
                                    'options' => [
                                        'label' => 'Submenu link 2',
                                        'uri' => '#',
                                        'icon' => 'fa fa-square',
                                    ],
                                ]
                            ]
                        ],
                        [
                            'options' => [
                                'label' => 'Submenu 2',
                                'route' => '',
                                'icon' => 'fa fa-gear',
                            ],
                            'pages' => [
                                [
                                    'options' => [
                                        'label' => 'Submenu link 1',
                                        'uri' => '#',
                                        'icon' => 'fa fa-square',
                                    ],
                                ],
                                [
                                    'options' => [
                                        'label' => 'Submenu link 2',
                                        'uri' => '#',
                                        'icon' => 'fa fa-square',
                                    ],
                                ]
                            ]
                        ],
                    ]
                ]
            ],

            'account_menu' => [
                'type' => 'ArrayProvider',
                'options' => [
                    'items' => [
                        [
                            'options' => [
                                'label' => 'Profile',
                                'route' => [
                                    'route_name' => 'admin',
                                    'route_params' => ['action' => 'account']
                                ],
                                'icon' => 'fa fa-user',
                            ]
                        ],
                        [
                            'options' => [
                                'label' => 'Settings',
                                'route' => [
                                    'route_name' => 'dashboard',
                                ],
                                'icon' => 'fa fa-cog',
                            ]
                        ],
                        [
                            'options' => [
                                'label' => 'Sign Out',
                                'route' => [
                                    'route_name' => 'admin',
                                    'route_params' => ['action' => 'logout']
                                ],
                                'icon' => 'fa fa-sign-out',
                            ]
                        ]
                    ]
                ]
            ]
        ],

        //register custom providers here
        'provider_manager' => []
    ],
];
