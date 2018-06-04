<?php
/**
 * @see https://github.com/dotkernel/admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/admin/blob/master/LICENSE.md MIT License
 */

namespace Admin\App\Middleware;

use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;
use Dot\Authentication\AuthenticationInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;

/**
 * Class AdminIndexMiddleware
 * @package Admin\App\Middleware
 *
 * @Service
 */
class AdminIndexMiddleware implements MiddlewareInterface
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
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
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

        return $handler->handle($request);
    }
}
