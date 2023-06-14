<?php

declare(strict_types=1);

namespace Frontend\Admin\Delegator;

use Frontend\Admin\Form\AdminForm;
use Frontend\Admin\Service\AdminService;
use interop\container\containerinterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class AdminRoleDelegator implements DelegatorFactoryInterface
{
    /**
     * @param string $name
     * @param array|null $options
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(containerinterface $container, $name, callable $callback, ?array $options = null): object
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
