<?php
/**
 * @see https://github.com/dotkernel/dot-admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-admin/blob/master/LICENSE.md MIT License
 */

namespace Admin\App\Middleware;

use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;
use Dot\Authentication\AuthenticationInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;

/**
 * Class AdminIndexMiddleware
 * @package Dot\Authentication\Middleware
 *
 * @Service
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
     *
     * @Inject({AuthenticationInterface::class, UrlHelper::class})
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
