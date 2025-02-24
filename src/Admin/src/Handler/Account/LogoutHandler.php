<?php

declare(strict_types=1);

namespace Admin\Admin\Handler\Account;

use Dot\DependencyInjection\Attribute\Inject;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Router\RouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LogoutHandler implements RequestHandlerInterface
{
    #[Inject(
        RouterInterface::class,
        AuthenticationServiceInterface::class,
    )]
    public function __construct(
        protected RouterInterface $router,
        protected AuthenticationServiceInterface $authenticationService,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->authenticationService->clearIdentity();

        return new RedirectResponse(
            $this->router->generateUri('admin::get-login-form')
        );
    }
}
