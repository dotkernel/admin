<?php

declare(strict_types=1);

namespace Admin\App;

use Admin\App\Handler\GetComponentViewHandler;
use Admin\App\Handler\GetIndexRedirectHandler;
use Mezzio\Application;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

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

        $app->get('/', GetIndexRedirectHandler::class, 'app::index-redirect');

        $routes = $container->get('config')['routes'] ?? [];
        foreach ($routes as $moduleName => $moduleRoutes) {
            foreach ($moduleRoutes as $routeUri => $templateName) {
                $app->get(
                    sprintf('/%s/%s', $moduleName, $routeUri),
                    [GetComponentViewHandler::class],
                    sprintf('%s::%s', $moduleName, $templateName)
                );
            }
        }

        return $app;
    }
}
