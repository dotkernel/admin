<?php

declare(strict_types=1);

namespace Admin\Dashboard;

use Admin\Dashboard\Handler\GetDashboardViewHandler;
use Mezzio\Application;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function assert;

class RoutesDelegator
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        $app = $callback();
        assert($app instanceof Application);

        $app->get('/dashboard', GetDashboardViewHandler::class, 'dashboard::dashboard-view');

        return $app;
    }
}
