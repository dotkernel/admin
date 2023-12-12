<?php

declare(strict_types=1);

namespace Frontend\App;

use Frontend\App\Controller\DashboardController;
use Frontend\App\Controller\PageController;
use Mezzio\Application;
use Psr\Container\ContainerInterface;

class RoutesDelegator
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        /** @var Application $app */
        $app = $callback();

        $app->get('/', DashboardController::class, 'dashboard');
        $app->get('/page[/{action}]', PageController::class, 'page');

        return $app;
    }
}
