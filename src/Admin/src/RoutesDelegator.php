<?php

declare(strict_types=1);

namespace Admin\Admin;

use Admin\Admin\Handler\Account\GetAccountEditFormHandler;
use Admin\Admin\Handler\Account\GetAccountLoginFormHandler;
use Admin\Admin\Handler\Account\GetAccountLogoutHandler;
use Admin\Admin\Handler\Account\PostAccountChangePasswordHandler;
use Admin\Admin\Handler\Account\PostAccountEditHandler;
use Admin\Admin\Handler\Account\PostAccountLoginHandler;
use Admin\Admin\Handler\Admin\GetAdminCreateFormHandler;
use Admin\Admin\Handler\Admin\GetAdminDeleteFormHandler;
use Admin\Admin\Handler\Admin\GetAdminEditFormHandler;
use Admin\Admin\Handler\Admin\GetAdminListHandler;
use Admin\Admin\Handler\Admin\GetAdminLoginListHandler;
use Admin\Admin\Handler\Admin\PostAdminCreateHandler;
use Admin\Admin\Handler\Admin\PostAdminDeleteHandler;
use Admin\Admin\Handler\Admin\PostAdminEditHandler;
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

        $routeCollector->group('/admin')
            ->get('/create-admin', GetAdminCreateFormHandler::class, 'admin::create-admin-form')
            ->post('/create-admin', PostAdminCreateHandler::class, 'admin::create-admin')
            ->get('/delete-admin/{uuid}', GetAdminDeleteFormHandler::class, 'admin::delete-admin-form')
            ->post('/delete-admin/{uuid}', PostAdminDeleteHandler::class, 'admin::delete-admin')
            ->get('/edit-admin/{uuid}', GetAdminEditFormHandler::class, 'admin::edit-admin-form')
            ->post('/edit-admin/{uuid}', PostAdminEditHandler::class, 'admin::edit-admin')
            ->get('/list-admin', GetAdminListHandler::class, 'admin::list-admin')
            ->get('/list-admin-login', GetAdminLoginListHandler::class, 'admin::list-admin-login');

        $routeCollector->group('/admin')
            ->post('/change-password', PostAccountChangePasswordHandler::class, 'admin::change-account-password')
            ->get('/edit-account', GetAccountEditFormHandler::class, 'admin::edit-account-form')
            ->post('/edit-account', PostAccountEditHandler::class, 'admin::edit-account');

        $routeCollector->get('/admin/login', GetAccountLoginFormHandler::class, 'admin::login-admin-form');
        $routeCollector->post('/admin/login', PostAccountLoginHandler::class, 'admin::login-admin');
        $routeCollector->get('/admin/logout', GetAccountLogoutHandler::class, 'admin::logout-admin');

        return $callback();
    }
}
