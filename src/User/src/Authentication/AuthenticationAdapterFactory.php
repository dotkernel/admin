<?php

declare(strict_types=1);

namespace Frontend\User\Authentication;

use Doctrine\ORM\EntityManager;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class AuthenticationAdapterFactory
{
    /**
     * @param ContainerInterface $container
     * @return AuthenticationAdapter
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function __invoke(ContainerInterface $container): AuthenticationAdapter
    {
        if (! $container->has(EntityManager::class)) {
            throw new Exception('EntityManager not found.');
        }

        /** @var array $config */
        $config = $container->get('config');
        if (! isset($config['doctrine']['authentication'])) {
            throw new Exception('Authentication config not found.');
        }
        return new AuthenticationAdapter(
            $container->get(EntityManager::class),
            $config['doctrine']['authentication']
        );
    }
}
