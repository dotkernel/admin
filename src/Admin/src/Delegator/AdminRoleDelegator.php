<?php

declare(strict_types=1);

namespace Admin\Admin\Delegator;

use Admin\Admin\Entity\AdminRole;
use Admin\Admin\Form\AdminForm;
use Admin\Admin\Service\AdminRoleServiceInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function array_map;

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
            $roleService = $container->get(AdminRoleServiceInterface::class);
            $adminForm->setRoles(array_map(function (AdminRole $role) {
                return [
                    'label'    => $role->getName()->value,
                    'value'    => $role->getUuid()->toString(),
                    'selected' => false,
                ];
            }, $roleService->getRoles()));
        }

        return $adminForm;
    }
}
