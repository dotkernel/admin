<?php
use Zend\Expressive\Application;
use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Helper;

return [
    // Provides application-wide services.
    // We recommend using fully-qualified class names whenever possible as
    // service names.
    'dependencies' => [
        // Use 'invokables' for constructor-less services, or services that do
        // not require arguments to the constructor. Map a service name to the
        // class name.
        'invokables' => [
            // Fully\Qualified\InterfaceName::class => Fully\Qualified\ClassName::class,
            Helper\ServerUrlHelper::class => Helper\ServerUrlHelper::class,
        ],
        // Use 'factories' for services provided by callbacks/factory classes.
        'factories' => [
            Application::class => ApplicationFactory::class,
            Helper\UrlHelper::class => Helper\UrlHelperFactory::class,

            \Dot\Admin\Admin\Service\AdminServiceInterface::class => \Dot\Admin\Admin\Factory\AdminServiceFactory::class,

            \Dot\Admin\Admin\Form\CreateAdminForm::class => \Dot\Admin\Admin\Factory\CreateAdminFormFactory::class,
            \Dot\Admin\Admin\Form\AdminFieldset::class => \Dot\Admin\Admin\Factory\AdminFieldsetFactory::class,
            \Dot\Admin\Admin\Form\InputFilter\AdminInputFilter::class => \Dot\Admin\Admin\Factory\AdminInputFilterFactory::class,
        ],
    ],
];
