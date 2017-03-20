<?php

use Zend\Expressive\Helper\ServerUrlMiddleware;
use Zend\Expressive\Helper\UrlHelperMiddleware;
use Zend\Expressive\Middleware\ImplicitHeadMiddleware;
use Zend\Expressive\Middleware\ImplicitOptionsMiddleware;
use Zend\Expressive\Middleware\NotFoundHandler;
use Zend\Stratigility\Middleware\ErrorHandler;
use Dot\Rbac\Guard\Middleware\ForbiddenHandler;
use Dot\Authentication\Web\ErrorHandler\UnauthorizedHandler;
use Dot\Session\SessionMiddleware;
use Dot\Navigation\NavigationMiddleware;
use Dot\Rbac\Guard\Middleware\RbacGuardMiddleware;
use Admin\App\Middleware\AdminIndexMiddleware;
use Dot\User\Middleware\AutoLogin;

/**
 * Setup middleware pipeline:
 */

// The error handler should be the first (most outer) middleware to catch
// all Exceptions.
/** @var \Zend\Expressive\Application $app */
$app->pipe(ErrorHandler::class);
// authentication and authorization error handlers
$app->pipe(ForbiddenHandler::class);
$app->pipe(UnauthorizedHandler::class);

$app->pipe(ServerUrlMiddleware::class);

// starts the session and tracks session activity
$app->pipe(SessionMiddleware::class);
// automatically login the user if it has a valid remember token
$app->pipe(AutoLogin::class);

// Pipe more middleware here that you want to execute on every request:
// - bootstrapping
// - pre-conditions
// - modifications to outgoing responses
//
// Piped Middleware may be either callables or service names. Middleware may
// also be passed as an array; each item in the array must resolve to
// middleware eventually (i.e., callable or service name).
//
// Middleware can be attached to specific paths, allowing you to mix and match
// applications under a common domain.  The handlers in each middleware
// attached this way will see a URI with the MATCHED PATH SEGMENT REMOVED!!!
//
// - $app->pipe('/api', $apiMiddleware);
// - $app->pipe('/docs', $apiDocMiddleware);
// - $app->pipe('/files', $filesMiddleware);

// Register the routing middleware in the middleware pipeline
$app->pipeRoutingMiddleware();
$app->pipe(ImplicitHeadMiddleware::class);
$app->pipe(ImplicitOptionsMiddleware::class);
$app->pipe(UrlHelperMiddleware::class);

// Add more middleware here that needs to introspect the routing results; this
// might include:
//
// - route-based authentication
// - route-based validation
// - etc.

$app->pipe(AdminIndexMiddleware::class);

$app->pipe(NavigationMiddleware::class);
$app->pipe(RbacGuardMiddleware::class);

// Register the dispatch middleware in the middleware pipeline
$app->pipeDispatchMiddleware();

// At this point, if no Response is return by any middleware, the
// NotFoundHandler kicks in; alternately, you can provide other fallback
// middleware to execute.
$app->pipe(NotFoundHandler::class);
