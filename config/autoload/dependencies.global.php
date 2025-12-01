<?php

declare(strict_types=1);

use Admin\App\Factory\AuthMiddlewareFactory;
use Admin\App\Middleware\AuthMiddleware;
use Dot\Authorization\AuthorizationInterface;
use Dot\Rbac\Authorization\AuthorizationService;

return [
    // Provides application-wide services.
    // We recommend using fully qualified class names whenever possible as service names.
    'dependencies' => [
        // Use 'aliases' to alias a service name to another service.
        // The key is the alias name, the value is the service to which it points.
        'aliases' => [
            AuthorizationInterface::class => AuthorizationService::class,
        ],
        // Use 'invokables' for constructorless services, or services that do not require arguments to the constructor.
        // Map a service name to the class name.
        'invokables' => [
            // Fully\Qualified\InterfaceName::class => Fully\Qualified\ClassName::class,
        ],
        // Use 'factories' for services provided by callbacks/factory classes.
        'factories' => [
            AuthMiddleware::class => AuthMiddlewareFactory::class,
        ],
    ],
];
