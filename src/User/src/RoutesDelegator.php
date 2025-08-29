<?php

declare(strict_types=1);

namespace Admin\User;

use Admin\User\Handler\GetUserCreateFormHandler;
use Admin\User\Handler\GetUserDeleteFormHandler;
use Admin\User\Handler\GetUserEditFormHandler;
use Admin\User\Handler\GetUserListHandler;
use Admin\User\Handler\PostUserAvatarEditHandler;
use Admin\User\Handler\PostUserCreateHandler;
use Admin\User\Handler\PostUserDeleteHandler;
use Admin\User\Handler\PostUserEditHandler;
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
            ->get('/create-user', GetUserCreateFormHandler::class, 'user::create-user-form')
            ->post('/create-user', PostUserCreateHandler::class, 'user::create-user')
            ->get('/delete-user/{uuid}', GetUserDeleteFormHandler::class, 'user::delete-user-form')
            ->post('/delete-user/{uuid}', PostUserDeleteHandler::class, 'user::delete-user')
            ->get('/edit-user/{uuid}', GetUserEditFormHandler::class, 'user::edit-user-form')
            ->post('/edit-user/{uuid}', PostUserEditHandler::class, 'user::edit-user')
            ->post('/edit-user-avatar/{uuid}', PostUserAvatarEditHandler::class, 'user::edit-user-avatar')
            ->get('/list-user', GetUserListHandler::class, 'user::list-user');

        return $callback();
    }
}
