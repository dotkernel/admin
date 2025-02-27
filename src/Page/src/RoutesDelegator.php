<?php

declare(strict_types=1);

namespace Admin\Page;

use Admin\Page\Handler\GetPageViewHandler;
use Mezzio\Application;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function assert;
use function sprintf;

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

        $routes = $container->get('config')['routes'] ?? [];
        foreach ($routes as $prefix => $moduleRoutes) {
            foreach ($moduleRoutes as $routeUri => $templateName) {
                $app->get(
                    sprintf('/%s/%s', $prefix, $routeUri),
                    [GetPageViewHandler::class],
                    sprintf('%s::%s', $prefix, $templateName)
                );
            }
        }

        return $app;
    }
}
