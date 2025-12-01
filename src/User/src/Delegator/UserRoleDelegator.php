<?php

declare(strict_types=1);

namespace Admin\User\Delegator;

use Admin\User\Form\CreateUserForm;
use Core\User\Entity\UserRole;
use Core\User\Enum\UserRoleEnum;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Form\Exception\ExceptionInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function array_filter;
use function array_map;

class UserRoleDelegator implements DelegatorFactoryInterface
{
    public const DEFAULT_ROLE = UserRoleEnum::User;

    /**
     * @param string $name
     * @throws ContainerExceptionInterface
     * @throws ExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, ?array $options = null): object
    {
        $userForm = $callback();
        if ($userForm instanceof CreateUserForm) {
            $userRoles = array_map(fn (UserRole $role): array => [
                'label'    => $role->getName()->value,
                'value'    => $role->getId()->toString(),
                'selected' => $role->getName() === self::DEFAULT_ROLE,
            ], $container->get(EntityManagerInterface::class)->getRepository(UserRole::class)->findAll());
            $userRoles = array_filter($userRoles, fn (array $role) => $role['label'] !== UserRoleEnum::Guest->value);

            $userForm->setRoles($userRoles);
        }

        return $userForm;
    }
}
