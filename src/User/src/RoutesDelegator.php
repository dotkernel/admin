<?php

namespace Frontend\User;

use Fig\Http\Message\RequestMethodInterface;
use Frontend\User\Controller\ActivateHandler;
use Frontend\User\Controller\LoginHandler;
use Frontend\User\Controller\LogoutHandler;
use Frontend\User\Controller\AccountController;
use Frontend\User\Controller\ProfileHandler;
use Frontend\User\Controller\RegisterHandler;
use Frontend\User\Controller\RequestResetPasswordHandler;
use Frontend\User\Controller\ResetPasswordHandler;
use Frontend\User\Controller\UnregisterHandler;
use Frontend\User\Controller\UserController;
use Mezzio\Application;
use Psr\Container\ContainerInterface;
use Twig\Profiler\Profile;

/**
 * Class RoutesDelegator
 * @package Frontend\User
 */
class RoutesDelegator
{
    /**
     * @param ContainerInterface $container
     * @param $serviceName
     * @param callable $callback
     * @return Application
     */
    public function __invoke(ContainerInterface $container, $serviceName, callable $callback)
    {
        /** @var Application $app */
        $app = $callback();

        $app->route(
            '/user[/{action}]',
            UserController::class,
            [RequestMethodInterface::METHOD_GET, RequestMethodInterface::METHOD_POST],
            'user'
        );

        $app->route(
            '/account[/{action}[/{hash}]]',
            AccountController::class,
            [RequestMethodInterface::METHOD_GET, RequestMethodInterface::METHOD_POST],
            'account'
        );

        return $app;
    }
}
