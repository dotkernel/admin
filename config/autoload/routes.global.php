<?php

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\FastRouteRouter::class,
        ],
        // Map middleware -> factories here
        'factories' => [
        ],
    ],

    'routes' => [
        [
            'name' => 'dashboard',
            'path' => '/dashboard[/{action}]',
            'middleware' => \Dot\Admin\Controller\DashboardController::class,
        ],
        [
            // there is already a route named `user` from dot-user package,
            // so we use a diff one for the frontend user management
            'name' => 'f_user',
            'path' => '/user[/{action}[/{id:\d+}]]',
            'middleware' => \Dot\Admin\Controller\UserController::class,
        ],
    ],
];
