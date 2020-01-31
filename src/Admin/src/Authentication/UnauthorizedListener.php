<?php
/**
 * @see https://github.com/dotkernel/admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/admin/blob/master/LICENSE.md MIT License
 */

namespace Admin\Admin\Authentication;

use Dot\Authentication\Web\Event\AbstractAuthenticationEventListener;
use Dot\Authentication\Web\Event\AuthenticationEvent;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;
use Mezzio\Router\RouteResult;

/**
 * Class UnauthorizedListener
 * Returns a 401 instead of a redirect response, must be registered before the default listener
 * defined in dot-authentication-web. It returns 401 just for a subset of routes, as ajax don't handle redirect well
 *
 * @package Admin\Admin\Listener
 */
class UnauthorizedListener extends AbstractAuthenticationEventListener
{
    /** @var array */
    protected $routes = ['user', 'f_user'];

    /** @var array */
    protected $actions = ['list', 'add', 'edit', 'delete'];

    /**
     * @param AuthenticationEvent $e
     * @return ResponseInterface|null
     */
    public function onUnauthorized(AuthenticationEvent $e)
    {
        /** @var ServerRequestInterface $request */
        $request = $e->getParam('request');
        /** @var RouteResult $routeMatch */
        $routeMatch = $request->getAttribute(RouteResult::class);
        if ($routeMatch) {
            $routeName = $routeMatch->getMatchedRouteName();
            $params = $routeMatch->getMatchedParams();
            $action = $params['action'] ?? 'index';

            if (in_array($routeName, $this->routes) && in_array($action, $this->actions)) {
                return new Response\EmptyResponse(401);
            }
        }
        // just to make the IDE shut up about returning something
        // only ResponseInterfaces return types are picked by the event trigger source
        return null;
    }
}
