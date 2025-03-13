<?php

declare(strict_types=1);

namespace Core\Admin;

use Core\Admin\DBAL\Types\AdminRoleEnumType;
use Core\Admin\DBAL\Types\AdminStatusEnumType;
use Core\Admin\DBAL\Types\SuccessFailureEnumType;
use Core\Admin\DBAL\Types\YesNoEnumType;
use Core\Admin\Entity\Admin;
use Core\Admin\Entity\AdminInterface;
use Core\Admin\Repository\AdminLoginRepository;
use Core\Admin\Repository\AdminRepository;
use Core\Admin\Repository\AdminRoleRepository;
use Core\Admin\Service\AdminRoleService;
use Core\Admin\Service\AdminRoleServiceInterface;
use Core\Admin\Service\AdminService;
use Core\Admin\Service\AdminServiceInterface;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Dot\DependencyInjection\Factory\AttributedRepositoryFactory;
use Dot\DependencyInjection\Factory\AttributedServiceFactory;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'doctrine'     => $this->getDoctrineConfig(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'factories' => [
                AdminService::class         => AttributedServiceFactory::class,
                AdminRoleService::class     => AttributedServiceFactory::class,
                AdminRepository::class      => AttributedRepositoryFactory::class,
                AdminRoleRepository::class  => AttributedRepositoryFactory::class,
                AdminLoginRepository::class => AttributedRepositoryFactory::class,
            ],
            'aliases'   => [
                AdminInterface::class            => Admin::class,
                AdminServiceInterface::class     => AdminService::class,
                AdminRoleServiceInterface::class => AdminRoleService::class,
            ],
        ];
    }

    public function getDoctrineConfig(): array
    {
        return [
            'driver' => [
                'orm_default'   => [
                    'drivers' => [
                        'Core\Admin\Entity' => 'AdminEntities',
                    ],
                ],
                'AdminEntities' => [
                    'class' => AttributeDriver::class,
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/Entity'],
                ],
            ],
            'types'  => [
                AdminStatusEnumType::NAME    => AdminStatusEnumType::class,
                SuccessFailureEnumType::NAME => SuccessFailureEnumType::class,
                YesNoEnumType::NAME          => YesNoEnumType::class,
                AdminRoleEnumType::NAME      => AdminRoleEnumType::class,
            ],
        ];
    }
}
