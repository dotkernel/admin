<?php

namespace Frontend\User\Authentication;

use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Storage\Session;
use Psr\Container\ContainerInterface;

class AuthenticationServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return AuthenticationService
     */
    public function __invoke(ContainerInterface $container): AuthenticationService
    {
        /** @var AuthenticationAdapter $authAdapter */
        $authAdapter = $container->get(AuthenticationAdapter::class);
        $session = new Session();
        return new AuthenticationService($session, $authAdapter);
    }
}
