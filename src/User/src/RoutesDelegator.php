<?php

namespace Frontend\User;

use Fig\Http\Message\RequestMethodInterface;
use Frontend\User\Controller\AdminController;
use Frontend\User\Controller\UserController;
use Mezzio\Application;
use Psr\Container\ContainerInterface;

/**
 * Class RoutesDelegator
 * @package Frontend\Admin
 */
class RoutesDelegator
{
    /**
     * @param ContainerInterface $container
     * @param $serviceName
     * @param callable $callback
     * @return Application
     */
    public function __invoke(ContainerInterface $container, $serviceName, callable $callback)
    {
        /** @var Application $app */
        $app = $callback();

        $app->route(
            '/admin[/{action}[/{uuid}]]',
            AdminController::class,
            [RequestMethodInterface::METHOD_GET, RequestMethodInterface::METHOD_POST],
            'admin'
        );

        $app->route(
            '/user[/{action}[/{uuid}]]',
            UserController::class,
            [RequestMethodInterface::METHOD_GET, RequestMethodInterface::METHOD_POST],
            'user'
        );

        return $app;
    }
}
