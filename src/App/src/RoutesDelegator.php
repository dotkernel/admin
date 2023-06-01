<?php

declare(strict_types=1);

namespace Frontend\App;

use Frontend\App\Controller\DashboardController;
use Mezzio\Application;
use Psr\Container\ContainerInterface;

/**
 * Class RoutesDelegator
 * @package Frontend\App
 */
class RoutesDelegator
{
    /**
     * @param ContainerInterface $container
     * @param string             $serviceName
     * @param callable           $callback
     *
     * @return Application
     */
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        /** @var Application $app */
        $app = $callback();

        $app->get('/', DashboardController::class, 'dashboard');

        return $app;
    }
}
