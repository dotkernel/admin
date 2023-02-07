<?php

declare(strict_types=1);

namespace Frontend\Admin\Authentication;

use Laminas\Authentication\AuthenticationService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class AuthenticationServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return AuthenticationService
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): AuthenticationService
    {
        /** @var AuthenticationAdapter $authAdapter */
        $authAdapter = $container->get(AuthenticationAdapter::class);
        return new AuthenticationService(null, $authAdapter);
    }
}
