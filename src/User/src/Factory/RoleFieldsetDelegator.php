<?php

declare(strict_types=1);

namespace Frontend\User\Factory;

use Frontend\User\Form\AdminForm;
use Frontend\User\Service\UserService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;

/**
 * Class RoleFieldsetDelegator
 * @package Frontend\User\Factory
 */
class RoleFieldsetDelegator implements DelegatorFactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $name
     * @param callable $callback
     * @param array|null $options
     * @return AdminForm|object
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        $adminForm = $callback();
        if ($adminForm instanceof AdminForm) {
            /** @var UserService $userService */
            $userService = $container->get(UserService::class);
            $roles = $userService->getFormProcessedRoles();

            $adminForm->setRoles($roles);
        }

        return $adminForm;
    }
}
