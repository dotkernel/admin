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
            ->get('/create-admin', GetAdminCreateFormHandler::class, 'admin::admin-create-form')
            ->post('/create-admin', PostAdminCreateHandler::class, 'admin::admin-create')
            ->get('/delete-admin/{uuid}', GetAdminDeleteFormHandler::class, 'admin::admin-delete-form')
            ->post('/delete-admin/{uuid}', PostAdminDeleteHandler::class, 'admin::admin-delete')
            ->get('/edit-admin/{uuid}', GetAdminEditFormHandler::class, 'admin::admin-edit-form')
            ->post('/edit-admin/{uuid}', PostAdminEditHandler::class, 'admin::admin-edit')
            ->get('/list-admin', GetAdminListHandler::class, 'admin::admin-list')
            ->get('/list-admin-login', GetAdminLoginListHandler::class, 'admin::admin-login-list');

        $routeCollector->group('/admin')
            ->post('/change-password', PostAccountChangePasswordHandler::class, 'admin::account-change-password')
            ->get('/edit-account', GetAccountEditFormHandler::class, 'admin::account-edit-form')
            ->post('/edit-account', PostAccountEditHandler::class, 'admin::account-edit');

        $routeCollector->get('/admin/login', GetAccountLoginFormHandler::class, 'admin::admin-login-form');
        $routeCollector->post('/admin/login', PostAccountLoginHandler::class, 'admin::admin-login');
        $routeCollector->get('/admin/logout', GetAccountLogoutHandler::class, 'admin::admin-logout');

        return $callback();
    }
}
