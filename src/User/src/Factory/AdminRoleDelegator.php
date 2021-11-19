<?php

declare(strict_types=1);

namespace Frontend\User\Factory;

use Frontend\User\Form\AdminForm;
use Frontend\User\Service\UserService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class AdminRoleDelegator
 * @package Frontend\User\Factory
 */
class AdminRoleDelegator implements DelegatorFactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $name
     * @param callable $callback
     * @param array|null $options
     * @return AdminForm|mixed|object
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        $adminForm = $callback();
        if ($adminForm instanceof AdminForm) {
            /** @var UserService $userService */
            $userService = $container->get(UserService::class);
            $roles = $userService->getAdminFormProcessedRoles();

            $adminForm->setRoles($roles);
        }

        return $adminForm;
    }
}
