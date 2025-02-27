<?php

declare(strict_types=1);

namespace Admin\Setting;

use Admin\Setting\Handler\GetSettingViewHandler;
use Admin\Setting\Handler\PostSettingStoreHandler;
use Mezzio\Application;
use Psr\Container\ContainerInterface;

class RoutesDelegator
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        /** @var Application $app */
        $app = $callback();

        $app->get('/setting/{identifier}', GetSettingViewHandler::class, 'setting::setting-view');
        $app->post('/setting/{identifier}', PostSettingStoreHandler::class, 'setting::setting-store');

        return $app;
    }
}
