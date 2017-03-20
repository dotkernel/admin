<?php
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
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */

/** @var \Zend\Expressive\Application $app */
$app->route(
    '/dashboard[/{action}]',
    \Admin\App\Controller\DashboardController::class,
    ['GET', 'POST'],
    'dashboard'
);

$app->route('/admin/login', \Dot\Authentication\Web\Action\LoginAction::class, ['GET', 'POST'], 'login');
$app->route('/admin/logout', \Dot\Authentication\Web\Action\LogoutAction::class, ['GET'], 'logout');
$app->route(
    '/admin[/{action}]',
    [
        \Admin\Admin\Controller\AdminController::class,
        \Dot\User\Controller\UserController::class
    ],
    ['GET', 'POST'],
    'user'
);

$app->route(
    '/user[/{action}]',
    \Admin\User\Controller\UserController::class,
    ['GET', 'POST'],
    'f_user'
);
