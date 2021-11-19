<?php

declare(strict_types=1);

namespace Frontend\User\Factory;

use Frontend\User\Form\UserForm;
use Frontend\User\Service\UserService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class UserRoleDelegator
 * @package Frontend\User\Factory
 */
class UserRoleDelegator implements DelegatorFactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $name
     * @param callable $callback
     * @param array|null $options
     * @return UserForm|mixed|object
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        $userForm = $callback();
        if ($userForm instanceof UserForm) {
            /** @var UserService $userService */
            $userService = $container->get(UserService::class);
            $roles = $userService->getUserFormProcessedRoles();

            $userForm->setRoles($roles);
        }

        return $userForm;
    }
}
