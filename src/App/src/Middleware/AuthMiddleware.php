<?php

declare(strict_types=1);

namespace Frontend\App\Middleware;

use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Rbac\Guard\Exception\RuntimeException;
use Dot\Rbac\Guard\Guard\GuardInterface;
use Dot\Rbac\Guard\Options\RbacGuardOptions;
use Dot\Rbac\Guard\Provider\GuardsProviderInterface;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Router\RouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public function __construct(
        protected RouterInterface $router,
        protected FlashMessengerInterface $messenger,
        protected GuardsProviderInterface $guardProvider,
        protected RbacGuardOptions $options
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $guards = $this->guardProvider->getGuards();

        //iterate over guards, which are sorted by priority
        //break on the first one that does not grant access

        $isGranted = $this->options->getProtectionPolicy() === GuardInterface::POLICY_ALLOW;

        foreach ($guards as $guard) {
            if (! $guard instanceof GuardInterface) {
                throw new RuntimeException("Guard is not an instance of " . GuardInterface::class);
            }
            //according to the policy, we whitelist or blacklist matched routes

            $r = $guard->isGranted($request);
            if ($r !== $isGranted) {
                $isGranted = $r;
                break;
            }
        }

        if (! $isGranted) {
            $this->messenger->addWarning(
                'You must sign in first in order to access the requested content',
                'user-login'
            );

            return new RedirectResponse($this->router->generateUri("admin", ['action' => 'login']));
        }

        return $handler->handle($request);
    }
}
