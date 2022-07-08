<?php

declare(strict_types=1);

namespace Frontend\Admin\Delegator;

use Frontend\Admin\Form\AdminForm;
use Frontend\Admin\Service\AdminService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class AdminRoleDelegator
 * @package Frontend\Admin\Delegator
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
            /** @var $adminService $adminService */
            $adminService = $container->get(AdminService::class);
            $roles = $adminService->getAdminFormProcessedRoles();

            $adminForm->setRoles($roles);
        }

        return $adminForm;
    }
}
