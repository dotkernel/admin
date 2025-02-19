<?php

declare(strict_types=1);

namespace Admin\App;

use Admin\App\Handler\ComponentHandler;
use Admin\App\Handler\IndexHandler;
use Mezzio\Application;
use Psr\Container\ContainerInterface;

class RoutesDelegator
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        /** @var Application $app */
        $app = $callback();

        $app->get('/', IndexHandler::class, 'page::dashboard');
        $app->get('/page/components', ComponentHandler::class, 'page::components');

        return $app;
    }
}
