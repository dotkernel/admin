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
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Server\MiddlewareInterface;

class AuthMiddlewareFactory
{
    use AttachAuthorizationEventListenersTrait;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): MiddlewareInterface
    {
        /** @var RbacGuardOptions $options */
        $options = $container->get(RbacGuardOptions::class);

        $guardsProviderFactory = new Factory($container, $container->get(GuardsProviderPluginManager::class));
        $guardsProvider        = $guardsProviderFactory->create($options->getGuardsProvider());

        return new AuthMiddleware(
            $container->get(RouterInterface::class),
            $container->get(FlashMessenger::class),
            $guardsProvider,
            $options
        );
    }
}
