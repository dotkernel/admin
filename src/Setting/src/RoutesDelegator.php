<?php

declare(strict_types=1);

namespace Frontend\Setting;

use Fig\Http\Message\RequestMethodInterface;
use Frontend\Setting\Controller\SettingController;
use Mezzio\Application;
use Psr\Container\ContainerInterface;

class RoutesDelegator
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        /** @var Application $app */
        $app = $callback();

        $app->route(
            '/setting/{action}[/{identifier}]',
            SettingController::class,
            [RequestMethodInterface::METHOD_GET, RequestMethodInterface::METHOD_POST],
            'setting'
        );

        return $app;
    }
}
