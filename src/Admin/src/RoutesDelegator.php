<?php

declare(strict_types=1);

namespace Admin\Admin;

use Admin\Admin\Handler\Account\GetEditAccountFormHandler;
use Admin\Admin\Handler\Account\GetLoginAccountFormHandler;
use Admin\Admin\Handler\Account\GetLogoutAccountHandler;
use Admin\Admin\Handler\Account\PostChangeAccountPasswordHandler;
use Admin\Admin\Handler\Account\PostEditAccountHandler;
use Admin\Admin\Handler\Account\PostLoginAccountHandler;
use Admin\Admin\Handler\Admin\GetCreateAdminFormHandler;
use Admin\Admin\Handler\Admin\GetDeleteAdminFormHandler;
use Admin\Admin\Handler\Admin\GetEditAdminFormHandler;
use Admin\Admin\Handler\Admin\GetListAdminHandler;
use Admin\Admin\Handler\Admin\GetListAdminLoginHandler;
use Admin\Admin\Handler\Admin\PostCreateAdminHandler;
use Admin\Admin\Handler\Admin\PostDeleteAdminHandler;
use Admin\Admin\Handler\Admin\PostEditAdminHandler;
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
            ->get('/create-admin', GetCreateAdminFormHandler::class, 'admin::create-admin-form')
            ->post('/create-admin', PostCreateAdminHandler::class, 'admin::create-admin')
            ->get('/delete-admin/{uuid}', GetDeleteAdminFormHandler::class, 'admin::delete-admin-form')
            ->post('/delete-admin/{uuid}', PostDeleteAdminHandler::class, 'admin::delete-admin')
            ->get('/edit-admin/{uuid}', GetEditAdminFormHandler::class, 'admin::edit-admin-form')
            ->post('/edit-admin/{uuid}', PostEditAdminHandler::class, 'admin::edit-admin')
            ->get('/list-admin', GetListAdminHandler::class, 'admin::list-admin')
            ->get('/list-admin-login', GetListAdminLoginHandler::class, 'admin::list-admin-login');

        $routeCollector->group('/admin')
            ->post('/change-password', PostChangeAccountPasswordHandler::class, 'admin::change-account-password')
            ->get('/edit-account', GetEditAccountFormHandler::class, 'admin::edit-account-form')
            ->post('/edit-account', PostEditAccountHandler::class, 'admin::edit-account');

        $routeCollector->get('/admin/login', GetLoginAccountFormHandler::class, 'admin::login-admin-form');
        $routeCollector->post('/admin/login', PostLoginAccountHandler::class, 'admin::login-admin');
        $routeCollector->get('/admin/logout', GetLogoutAccountHandler::class, 'admin::logout-admin');

        return $callback();
    }
}
