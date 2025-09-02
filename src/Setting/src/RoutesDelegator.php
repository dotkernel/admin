<?php

declare(strict_types=1);

namespace Admin\Setting;

use Admin\Setting\Handler\GetViewSettingHandler;
use Admin\Setting\Handler\PostStoreSettingHandler;
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
            ->get('/{identifier}', GetViewSettingHandler::class, 'setting::view-setting')
            ->post('/{identifier}', PostStoreSettingHandler::class, 'setting::store-setting');

        return $callback();
    }
}
