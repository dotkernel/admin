<?php

declare(strict_types=1);

namespace Frontend\Admin;

use Fig\Http\Message\RequestMethodInterface;
use Frontend\Admin\Controller\AdminController;
use Mezzio\Application;
use Psr\Container\ContainerInterface;

class RoutesDelegator
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
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
