<?php

declare(strict_types=1);

namespace Admin\User;

use Admin\User\Handler\GetCreateUserFormHandler;
use Admin\User\Handler\GetDeleteUserFormHandler;
use Admin\User\Handler\GetEditUserFormHandler;
use Admin\User\Handler\GetListUserHandler;
use Admin\User\Handler\PostCreateUserHandler;
use Admin\User\Handler\PostDeleteUserHandler;
use Admin\User\Handler\PostEditUserAvatarHandler;
use Admin\User\Handler\PostEditUserHandler;
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

        $routeCollector->group('/user')
            ->get('/create-user', GetCreateUserFormHandler::class, 'user::create-user-form')
            ->post('/create-user', PostCreateUserHandler::class, 'user::create-user')
            ->get('/delete-user/{uuid}', GetDeleteUserFormHandler::class, 'user::delete-user-form')
            ->post('/delete-user/{uuid}', PostDeleteUserHandler::class, 'user::delete-user')
            ->get('/edit-user/{uuid}', GetEditUserFormHandler::class, 'user::edit-user-form')
            ->post('/edit-user/{uuid}', PostEditUserHandler::class, 'user::edit-user')
            ->post('/edit-user-avatar/{uuid}', PostEditUserAvatarHandler::class, 'user::edit-user-avatar')
            ->get('/list-user', GetListUserHandler::class, 'user::list-user');

        return $callback();
    }
}
