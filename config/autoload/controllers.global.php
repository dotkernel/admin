<?php

return [

    'dependencies' => [
        'factories' => [
            \Dot\Admin\Controller\DashboardController::class =>
                \Zend\ServiceManager\Factory\InvokableFactory::class,

            \Dot\Admin\User\Controller\UserController::class =>
                \Zend\ServiceManager\Factory\InvokableFactory::class,

            \Dot\Admin\Admin\Controller\AdminController::class =>
                \Dot\Admin\Admin\Factory\AdminControllerFactory::class,
        ]
    ],

    'dot_controller' => [

        'plugin_manager' => []
    ],
];
