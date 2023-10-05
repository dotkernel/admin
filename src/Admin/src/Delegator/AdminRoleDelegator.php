<?php

declare(strict_types=1);

namespace Frontend\Admin\Delegator;

use Frontend\Admin\Form\AdminForm;
use Frontend\Admin\Service\AdminService;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class AdminRoleDelegator implements DelegatorFactoryInterface
{
    /**
     * @param string $name
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, ?array $options = null): object
    {
        $adminForm = $callback();
        if ($adminForm instanceof AdminForm) {
            $adminService = $container->get(AdminService::class);
            $roles        = $adminService->getAdminFormProcessedRoles();

            $adminForm->setRoles($roles);
        }

        return $adminForm;
    }
}
