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
use Mezzio\Application;
use Psr\Container\ContainerInterface;

class RoutesDelegator
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        /** @var Application $app */
        $app = $callback();

        $app->get('/admin/create-admin', GetAdminCreateFormHandler::class, 'admin::admin-create-form');
        $app->post('/admin/create-admin', PostAdminCreateHandler::class, 'admin::admin-create');

        $app->get('/admin/edit-admin/{uuid}', GetAdminEditFormHandler::class, 'admin::admin-edit-form');
        $app->post('/admin/edit-admin/{uuid}', PostAdminEditHandler::class, 'admin::admin-edit');

        $app->get('/admin/delete-admin/{uuid}', GetAdminDeleteFormHandler::class, 'admin::admin-delete-form');
        $app->post('/admin/delete-admin/{uuid}', PostAdminDeleteHandler::class, 'admin::admin-delete');

        $app->get('/admin/list-admin', GetAdminListHandler::class, 'admin::admin-list');
        $app->get('/admin/list-admin-login', GetAdminLoginListHandler::class, 'admin::admin-login-list');

        $app->get('/admin/edit-account', GetAccountEditFormHandler::class, 'admin::account-edit-form');
        $app->post('/admin/edit-account', PostAccountEditHandler::class, 'admin::edit-account');
        $app->post('/admin/edit-password', PostAccountChangePasswordHandler::class, 'admin::account-change-password');

        $app->get('/admin/login', GetAccountLoginFormHandler::class, 'admin::admin-login-form');
        $app->post('/admin/login', PostAccountLoginHandler::class, 'admin::admin-login');
        $app->get('/admin/logout', GetAccountLogoutHandler::class, 'admin::admin-logout');

        return $app;
    }
}
