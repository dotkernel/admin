<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/7/2016
 * Time: 7:23 PM
 */

namespace Dot\Admin\Middleware;


use Dot\Authentication\AuthenticationInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;

/**
 * Class AdminIndexMiddleware
 * @package Dot\Authentication\Middleware
 */
class AdminIndexMiddleware
{
    /** @var  AuthenticationInterface */
    protected $authentication;

    /** @var  UrlHelper */
    protected $urlHelper;

    /**
     * AdminIndexMiddleware constructor.
     * @param AuthenticationInterface $authentication
     * @param UrlHelper $urlHelper
     */
    public function __construct(AuthenticationInterface $authentication, UrlHelper $urlHelper)
    {
        $this->authentication = $authentication;
        $this->urlHelper = $urlHelper;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return RedirectResponse
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        //if root path is accessed and not authenticated send to login page
        //we do this to make interface more user-friendly, by bypassing the authorization guards
        if ($request->getUri()->getPath() === '/') {
            if (!$this->authentication->hasIdentity()) {
                return new RedirectResponse($this->urlHelper->generate('login'));
            } else {
                return new RedirectResponse($this->urlHelper->generate('dashboard'));
            }

        }

        return $next($request, $response);
    }
}
