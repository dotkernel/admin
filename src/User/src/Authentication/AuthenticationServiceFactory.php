<?php

declare(strict_types=1);

namespace Frontend\User\Authentication;

use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Storage\Session;
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
        $session = new Session();
        return new AuthenticationService($session, $authAdapter);
    }
}
