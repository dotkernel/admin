<?php

declare(strict_types=1);

namespace Admin\Admin;

use Admin\Admin\Handler\AdminListHandler;
use Admin\Admin\Handler\AdminListLoginHandler;
use Admin\Admin\Handler\ChangePasswordHandler;
use Admin\Admin\Handler\CreateAdminHandler;
use Admin\Admin\Handler\DeleteAdminHandler;
use Admin\Admin\Handler\EditAccountHandler;
use Admin\Admin\Handler\EditAdminHandler;
use Admin\Admin\Handler\GetAccountFormHandler;
use Admin\Admin\Handler\GetAdminFormHandler;
use Admin\Admin\Handler\GetDeleteAdminFormHandler;
use Admin\Admin\Handler\GetEditAdminFormHandler;
use Admin\Admin\Handler\GetLoginFormHandler;
use Admin\Admin\Handler\LoginHandler;
use Admin\Admin\Handler\LogoutHandler;
use Mezzio\Application;
use Psr\Container\ContainerInterface;

class RoutesDelegator
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        /** @var Application $app */
        $app = $callback();

        $app->get('/admin/add', GetAdminFormHandler::class, 'admin::get-admin-form');
        $app->post('/admin/add', CreateAdminHandler::class, 'admin::create-admin');

        $app->get('/admin/edit/{uuid}', GetEditAdminFormHandler::class, 'admin::get-edit-admin-form');
        $app->post('/admin/edit/{uuid}', EditAdminHandler::class, 'admin::edit-admin');

        $app->get('/admin/delete/{uuid}', GetDeleteAdminFormHandler::class, 'admin::get-delete-admin-form');
        $app->post('/admin/delete/{uuid}', DeleteAdminHandler::class, 'admin::delete-admin');

        $app->get('/admin/list', AdminListHandler::class, 'admin::list');
        $app->get('/admin/logins', AdminListLoginHandler::class, 'admin::list-logins');

        $app->get('/admin/account', GetAccountFormHandler::class, 'admin::account');
        $app->post('/admin/account', EditAccountHandler::class, 'admin::edit-account');

        $app->post('/admin/change-password', ChangePasswordHandler::class, 'admin::change-password');
        $app->get('/admin/login', GetLoginFormHandler::class, 'admin::get-login-form');

        $app->post('/admin/login', LoginHandler::class, 'admin::login');
        $app->get('/admin/logout', LogoutHandler::class, 'admin::logout');

//        $app->route(
//            '/admin[/{action}[/{uuid}]]',
//            AdminController::class,
//            [RequestMethodInterface::METHOD_GET, RequestMethodInterface::METHOD_POST],
//            'admin'
//        );

        return $app;
    }
}
