<?php

declare(strict_types=1);

namespace Admin\App\Handler;

use Dot\DependencyInjection\Attribute\Inject;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Router\RouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetIndexRedirectHandler implements RequestHandlerInterface
{
    #[Inject(
        AuthenticationServiceInterface::class,
        RouterInterface::class,
    )]
    public function __construct(
        protected AuthenticationServiceInterface $authenticationService,
        protected RouterInterface $router,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->authenticationService->hasIdentity()) {
            return new RedirectResponse($this->router->generateUri('dashboard::dashboard-view'));
        }

        return new RedirectResponse($this->router->generateUri('admin::admin-login-form'));
    }
}
