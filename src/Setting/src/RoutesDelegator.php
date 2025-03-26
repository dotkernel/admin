<?php

declare(strict_types=1);

namespace Admin\Setting;

use Admin\Setting\Handler\GetSettingViewHandler;
use Admin\Setting\Handler\PostSettingStoreHandler;
use Dot\Router\RouteCollectorInterface;
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
        /** @var RouteCollectorInterface $routeCollector */
        $routeCollector = $container->get(RouteCollectorInterface::class);

        $routeCollector->group('/setting')
            ->get('/{identifier}', GetSettingViewHandler::class, 'setting::setting-view')
            ->post('/{identifier}', PostSettingStoreHandler::class, 'setting::setting-store');

        return $callback();
    }
}
