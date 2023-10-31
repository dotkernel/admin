<?php

declare(strict_types=1);

namespace Frontend\Admin;

use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Dot\AnnotatedServices\Factory\AnnotatedServiceFactory;
use Frontend\Admin\Adapter\AuthenticationAdapter;
use Frontend\Admin\Controller\AdminController;
use Frontend\Admin\Delegator\AdminRoleDelegator;
use Frontend\Admin\Entity\Admin;
use Frontend\Admin\Entity\AdminInterface;
use Frontend\Admin\Factory\AuthenticationServiceFactory;
use Frontend\Admin\Form\AdminForm;
use Frontend\Admin\Form\ChangePasswordForm;
use Frontend\Admin\Form\LoginForm;
use Frontend\Admin\Service\AdminService;
use Frontend\Admin\Service\AdminServiceInterface;
use Laminas\Authentication\AuthenticationService;
use Laminas\Form\ElementFactory;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'form'         => $this->getForms(),
            'doctrine'     => $this->getDoctrineConfig(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'factories'  => [
                AdminController::class       => AnnotatedServiceFactory::class,
                AdminService::class          => AnnotatedServiceFactory::class,
                AdminForm::class             => ElementFactory::class,
                AuthenticationService::class => AuthenticationServiceFactory::class,
                AuthenticationAdapter::class => AnnotatedServiceFactory::class,
            ],
            'aliases'    => [
                AdminInterface::class        => Admin::class,
                AdminServiceInterface::class => AdminService::class,
            ],
            'delegators' => [
                AdminForm::class => [
                    AdminRoleDelegator::class,
                ],
            ],
        ];
    }

    public function getTemplates(): array
    {
        return [
            'paths' => [
                'admin' => [__DIR__ . '/../templates/admin'],
            ],
        ];
    }

    public function getForms(): array
    {
        return [
            'form_manager' => [
                'factories'  => [
                    LoginForm::class          => ElementFactory::class,
                    ChangePasswordForm::class => ElementFactory::class,
                ],
                'aliases'    => [],
                'delegators' => [],
            ],
        ];
    }

    public function getDoctrineConfig(): array
    {
        return [
            'driver' => [
                'orm_default'   => [
                    'drivers' => [
                        'Frontend\Admin\Entity' => 'AdminEntities',
                    ],
                ],
                'AdminEntities' => [
                    'class' => AttributeDriver::class,
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/Entity'],
                ],
            ],
        ];
    }
}
