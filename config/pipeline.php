<?php

use Admin\App\Middleware\AdminIndexMiddleware;
use Dot\Authentication\Web\ErrorHandler\UnauthorizedHandler;
use Dot\Navigation\NavigationMiddleware;
use Dot\Rbac\Guard\Middleware\ForbiddenHandler;
use Dot\Rbac\Guard\Middleware\RbacGuardMiddleware;
use Dot\Session\SessionMiddleware;
use Dot\User\Middleware\AutoLogin;
use Mezzio\Helper\ServerUrlMiddleware;
use Mezzio\Helper\UrlHelperMiddleware;
use Mezzio\Middleware\ImplicitHeadMiddleware;
use Mezzio\Middleware\ImplicitOptionsMiddleware;
use Mezzio\Middleware\NotFoundHandler;
use Laminas\Stratigility\Middleware\ErrorHandler;

// new middleware
use Psr\Container\ContainerInterface;
use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Mezzio\Router\Middleware\RouteMiddleware;
use Mezzio\Router\Middleware\DispatchMiddleware;

/**
 * Setup middleware pipeline:
 */

// The error handler should be the first (most outer) middleware to catch
// all Exceptions.
/** @var \Mezzio\Application $app */
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    $app->pipe(ErrorHandler::class);
    $app->pipe(ServerUrlMiddleware::class);

    // starts the session and tracks session activity
    $app->pipe(SessionMiddleware::class);

    // automatically login the user if it has a valid remember token
    $app->pipe(AutoLogin::class);

    // Pipe more middleware here that you want to execute on every request:
    // - bootstrapping
    // - pre-conditions
    // - modifications to outgoing responses

    // Register the routing middleware in the middleware pipeline
    $app->pipe(RouteMiddleware::class);

    // mezzio middleware
    $app->pipe(ImplicitHeadMiddleware::class);
    $app->pipe(ImplicitOptionsMiddleware::class);
    $app->pipe(UrlHelperMiddleware::class);

    // authentication and authorization error handlers
    // this is piped here to have access to the route result
    // it should be ok, as these particular errors are generated from below middleware or routed middleware
    $app->pipe(ForbiddenHandler::class);
    $app->pipe(UnauthorizedHandler::class);

    // Add more middleware here that needs to introspect the routing results; this
    // ...

    // this middleware redirects to login or dashboard, based on authentication status, if `/` path is accessed
    // this is just to make the UI more friendly, by by-passing the rbac guards in this particular case
    $app->pipe(AdminIndexMiddleware::class);

    // navigation middleware makes sure the navigation service is injected the RouteResult
    $app->pipe(NavigationMiddleware::class);

    // the RBAC guards protect chunks of the application(routes or controllers or controller actions)
    // the authorization service can be used together with the guards for maximum security and finer control
    $app->pipe(RbacGuardMiddleware::class);

    // Register the dispatch middleware in the middleware pipeline
    $app->pipe(DispatchMiddleware::class);

    // At this point, if no Response is return by any middleware, the
    // NotFoundHandler kicks in; alternately, you can provide other fallback
    // middleware to execute.
    $app->pipe(NotFoundHandler::class);
};
