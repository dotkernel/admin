<?php

declare(strict_types=1);

namespace Admin\Setting;

use Admin\Setting\Handler\GetSettingHandler;
use Admin\Setting\Handler\StoreSettingHandler;
use Mezzio\Application;
use Psr\Container\ContainerInterface;

class RoutesDelegator
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        /** @var Application $app */
        $app = $callback();

        $app->get('/setting/get-setting/{identifier}', GetSettingHandler::class, 'setting::get-setting');
        $app->post('/setting/store-setting/{identifier}', StoreSettingHandler::class, 'setting::store-setting');

        return $app;
    }
}
