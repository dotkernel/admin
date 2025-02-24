<?php

declare(strict_types=1);

namespace Admin\Admin;

use Admin\Admin\Handler\Account\ChangePasswordHandler;
use Admin\Admin\Handler\Account\EditAdminAccountResourceHandler;
use Admin\Admin\Handler\Account\GetAdminAccountFormHandler;
use Admin\Admin\Handler\Account\GetAdminLoginFormHandler;
use Admin\Admin\Handler\Account\LoginHandler;
use Admin\Admin\Handler\Account\LogoutHandler;
use Admin\Admin\Handler\Admin\DeleteAdminResourceHandler;
use Admin\Admin\Handler\Admin\EditAdminResourceHandler;
use Admin\Admin\Handler\Admin\GetAdminCollectionHandler;
use Admin\Admin\Handler\Admin\GetAdminCreateFormHandler;
use Admin\Admin\Handler\Admin\GetAdminDeleteFormHandler;
use Admin\Admin\Handler\Admin\GetAdminEditFormHandler;
use Admin\Admin\Handler\Admin\GetAdminListCollectionHandler;
use Admin\Admin\Handler\Admin\PostAdminResourceHandler;
use Mezzio\Application;
use Psr\Container\ContainerInterface;

class RoutesDelegator
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        /** @var Application $app */
        $app = $callback();

        $app->get('/admin/create-admin', GetAdminCreateFormHandler::class, 'admin::create-admin-form');
        $app->post('/admin/create-admin', PostAdminResourceHandler::class, 'admin::create-admin');

        $app->get('/admin/edit-admin/{uuid}', GetAdminEditFormHandler::class, 'admin::edit-admin-form');
        $app->post('/admin/edit-admin/{uuid}', EditAdminResourceHandler::class, 'admin::edit-admin');

        $app->get('/admin/delete-admin/{uuid}', GetAdminDeleteFormHandler::class, 'admin::delete-admin-form');
        $app->post('/admin/delete-admin/{uuid}', DeleteAdminResourceHandler::class, 'admin::delete-admin');

        $app->get('/admin/list-admins', GetAdminCollectionHandler::class, 'admin::list-admins');
        $app->get('/admin/list-admin-logins', GetAdminListCollectionHandler::class, 'admin::list-admin-logins');

        $app->get('/admin/account', GetAdminAccountFormHandler::class, 'admin::account-form');
        $app->post('/admin/account/edit-account', EditAdminAccountResourceHandler::class, 'admin::edit-account');

        $app->post('/admin/account/edit-password', ChangePasswordHandler::class, 'admin::change-password');
        $app->get('/admin/login', GetAdminLoginFormHandler::class, 'admin::get-login-form');

        $app->post('/admin/login', LoginHandler::class, 'admin::login');
        $app->get('/admin/logout', LogoutHandler::class, 'admin::logout');

        return $app;
    }
}
