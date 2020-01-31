<?php

use Admin\Admin\Controller\AdminController;
use Admin\App\Controller\DashboardController;
use Admin\User\Controller\UserController as UserManagementController;
use Dot\Authentication\Web\Action\LoginAction;
use Dot\Authentication\Web\Action\LogoutAction;
use Dot\User\Controller\UserController as UserController;

// new middleware
use Psr\Container\ContainerInterface;
use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Mezzio\Router\Middleware\RouteMiddleware;
use Mezzio\Router\Middleware\DispatchMiddleware;

return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    /**
     * Setup routes with a single request method:
     *
     * $app->get('/', App\Action\HomePageAction::class, 'home');
     * $app->post('/album', App\Action\AlbumCreateAction::class, 'album.create');
     * $app->put('/album/:id', App\Action\AlbumUpdateAction::class, 'album.put');
     * $app->patch('/album/:id', App\Action\AlbumUpdateAction::class, 'album.patch');
     * $app->delete('/album/:id', App\Action\AlbumDeleteAction::class, 'album.delete');
     *
     * Or with multiple request methods:
     *
     * $app->route('/contact', App\Action\ContactAction::class, ['GET', 'POST', ...], 'contact');
     *
     * Or handling all request methods:
     *
     * $app->route('/contact', App\Action\ContactAction::class)->setName('contact');
     *
     * or:
     *
     * $app->route(
     *     '/contact',
     *     App\Action\ContactAction::class,
     *     Mezzio\Router\Route::HTTP_METHOD_ANY,
     *     'contact'
     * );
     */

    /** @var \Mezzio\Application $app */
    // Dashboard controller route
    $app->route('/dashboard[/{action}]', DashboardController::class, ['GET', 'POST'], 'dashboard');

    // following three routes are for user(in this case user refers to the admin user) authentication and management
    $app->route('/admin/login', LoginAction::class, ['GET', 'POST'], 'login');
    $app->route('/admin/logout', LogoutAction::class, ['GET'], 'logout');
    $app->route('/admin[/{action}[/{id}]]', [AdminController::class, UserController::class], ['GET', 'POST'], 'user');

    // this route is for the frontend user management(hence the f_ prefix)
    // if this admin application is used without the frontend application(no frontend user management required)
    // you can remove the Admin\User module together with any configuration related to it
    // TODO: we'll offer the option to use admin package without frontend in future releases, as installation scripts
    $app->route('/user[/{action}[/{id}]]', UserManagementController::class, ['GET', 'POST'], 'f_user');
};
