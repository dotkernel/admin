<?php

namespace Frontend\Admin;

use Fig\Http\Message\RequestMethodInterface;
use Frontend\Admin\Controller\AdminController;
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

        return $app;
    }
}
