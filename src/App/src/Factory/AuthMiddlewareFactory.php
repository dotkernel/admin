<?php

declare(strict_types=1);

namespace Frontend\App\Factory;

use Dot\FlashMessenger\FlashMessenger;
use Dot\Rbac\Guard\Factory\AttachAuthorizationEventListenersTrait;
use Dot\Rbac\Guard\Options\RbacGuardOptions;
use Dot\Rbac\Guard\Provider\Factory;
use Dot\Rbac\Guard\Provider\GuardsProviderPluginManager;
use Frontend\App\Middleware\AuthMiddleware;
use Mezzio\Router\RouterInterface;
use Psr\Container\ContainerInterface;

class AuthMiddlewareFactory
{
    use AttachAuthorizationEventListenersTrait;

    /**
     * @return mixed
     */
    public function __invoke(ContainerInterface $container, string $requestedName): AuthMiddleware
    {
        /** @var RbacGuardOptions $options */
        $options = $container->get(RbacGuardOptions::class);

        $guardsProviderFactory = new Factory($container, $container->get(GuardsProviderPluginManager::class));
        $guardsProvider        = $guardsProviderFactory->create($options->getGuardsProvider());

        return new $requestedName(
            $container->get(RouterInterface::class),
            $container->get(FlashMessenger::class),
            $guardsProvider,
            $options
        );
    }
}
