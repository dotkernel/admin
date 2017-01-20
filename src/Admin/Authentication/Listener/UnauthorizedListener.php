<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 12/12/2016
 * Time: 3:23 PM
 */

namespace Dot\Admin\Authentication\Listener;

use Dot\Authentication\Web\Event\AuthenticationEvent;
use Zend\Diactoros\Response;
use Zend\Expressive\Router\RouteResult;

/**
 * Class UnauthorizedListener
 * Returns a 401 instead of a redirect response, must be registered before the default listener
 * defined in dot-authentication-web. It returns 401 just for a subset of routes, as ajax don't handle redirect well
 *
 * @package Dot\Admin\Authentication\Listener
 */
class UnauthorizedListener
{
    protected $routes = ['user', 'f_user'];

    protected $actions = ['list', 'add', 'edit', 'delete'];

    public function __invoke(AuthenticationEvent $e)
    {
        $request = $e->getRequest();
        /** @var RouteResult $routeMatch */
        $routeMatch = $request->getAttribute(RouteResult::class, null);

        if ($routeMatch) {
            $routeName = $routeMatch->getMatchedRouteName();
            $params = $routeMatch->getMatchedParams();
            $action = isset($params['action']) ? $params['action'] : '';

            if (in_array($routeName, $this->routes) && in_array($action, $this->actions)) {
                return new Response\EmptyResponse(401);
            }
        }

        return true;
    }
}
