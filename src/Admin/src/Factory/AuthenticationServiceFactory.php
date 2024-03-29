<?php

declare(strict_types=1);

namespace Frontend\Admin\Factory;

use Frontend\Admin\Adapter\AuthenticationAdapter;
use Laminas\Authentication\AuthenticationService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class AuthenticationServiceFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): AuthenticationService
    {
        return new AuthenticationService(
            null,
            $container->get(AuthenticationAdapter::class)
        );
    }
}
