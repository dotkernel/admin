<?php

/**
 * @see https://github.com/dotkernel/dot-rbac-guard/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-rbac-guard/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Frontend\App\Factory;

use Dot\FlashMessenger\FlashMessenger;
use Dot\Rbac\Guard\Factory\AttachAuthorizationEventListenersTrait;
use Dot\Rbac\Guard\Options\RbacGuardOptions;
use Dot\Rbac\Guard\Provider\Factory;
use Dot\Rbac\Guard\Provider\GuardsProviderPluginManager;
use Mezzio\Router\RouterInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class AuthMiddlewareFactory
 * @package Dot\Rbac\Guard\Factory
 */
class AuthMiddlewareFactory
{
    use AttachAuthorizationEventListenersTrait;

    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName)
    {
        /** @var RbacGuardOptions $options */
        $options = $container->get(RbacGuardOptions::class);

        $guardsProviderFactory = new Factory($container, $container->get(GuardsProviderPluginManager::class));
        $guardsProvider = $guardsProviderFactory->create($options->getGuardsProvider());

        /** @var AuthMiddlewareFactory $middleware */
        return new $requestedName(
            $container->get(RouterInterface::class),
            $container->get(FlashMessenger::class),
            $guardsProvider,
            $options
        );
    }
}
