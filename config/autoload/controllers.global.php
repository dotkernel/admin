<?php

return [

    'dependencies' => [
        'factories' => [
            \Dot\Admin\Controller\DashboardController::class =>
                \Zend\ServiceManager\Factory\InvokableFactory::class,

            \Dot\Admin\Controller\UserController::class =>
                \Dot\Admin\Factory\User\UserControllerFactory::class,

            \Dot\Admin\Controller\AdminController::class =>
                \Dot\Admin\Factory\Admin\AdminControllerFactory::class,
        ]
    ],

    'dot_controller' => [

        'plugin_manager' => []
    ],
];
