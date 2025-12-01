<?php

declare(strict_types=1);

namespace Admin\Admin\Delegator;

use Admin\Admin\Form\CreateAdminForm;
use Core\Admin\Entity\AdminRole;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Form\Exception\ExceptionInterface;
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
     * @throws ExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, ?array $options = null): object
    {
        $adminForm = $callback();
        if ($adminForm instanceof CreateAdminForm) {
            $adminForm->setRoles(
                array_map(fn (AdminRole $role): array => [
                    'label'    => $role->getName()->value,
                    'value'    => $role->getId()->toString(),
                    'selected' => false,
                ], $container->get(EntityManagerInterface::class)->getRepository(AdminRole::class)->findAll())
            );
        }

        return $adminForm;
    }
}
