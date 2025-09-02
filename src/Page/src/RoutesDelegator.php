<?php

declare(strict_types=1);

namespace Admin\Page;

use Admin\Page\Handler\GetViewPageHandler;
use Dot\Router\RouteCollectorInterface;
use Mezzio\Application;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function sprintf;

class RoutesDelegator
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        /** @var RouteCollectorInterface $routeCollector */
        $routeCollector = $container->get(RouteCollectorInterface::class);

        $routes = $container->get('config')['routes'] ?? [];
        foreach ($routes as $prefix => $moduleRoutes) {
            foreach ($moduleRoutes as $routeUri => $templateName) {
                $routeCollector->get(
                    sprintf('/%s/%s', $prefix, $routeUri),
                    [GetViewPageHandler::class],
                    sprintf('%s::%s', $prefix, $templateName)
                );
            }
        }

        return $callback();
    }
}
