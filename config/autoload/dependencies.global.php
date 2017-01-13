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

            /** Admin entity related dependencies */
            \Dot\Admin\Form\Admin\AdminForm::class =>
                \Dot\Admin\Factory\Admin\AdminFormFactory::class,

            \Dot\Admin\Form\Admin\AdminFieldset::class =>
                \Dot\Admin\Factory\Admin\AdminFieldsetFactory::class,

            \Dot\Admin\Form\Admin\AdminInputFilter::class =>
                \Dot\Admin\Factory\Admin\AdminInputFilterFactory::class,

            /** User entity related dependencies */
            \Dot\Admin\Form\User\UserDetailsInputFilter::class =>
                \Dot\Admin\Factory\User\UserDetailsInputFilterFactory::class,

            \Dot\Admin\Form\User\UserInputFilter::class =>
                \Dot\Admin\Factory\User\UserInputFilterFactory::class,

            \Dot\Admin\Form\User\UserDetailsFieldset::class =>
                \Dot\Admin\Factory\User\UserDetailsFieldsetFactory::class,

            \Dot\Admin\Form\User\UserFieldset::class =>
                \Dot\Admin\Factory\User\UserFieldsetFactory::class,

            \Dot\Admin\Form\User\UserForm::class =>
                \Dot\Admin\Factory\User\UserFormFactory::class,

            \Dot\Admin\Service\Listener\AdminServiceListener::class =>
                \Dot\Admin\Factory\AdminServiceListenerFactory::class,

        ],

        'delegators' => [
            'dot-ems.service.user' => [
                \Dot\Admin\Factory\User\UserServiceDelegator::class,
            ],
            'dot-ems.service.admin' => [
                \Dot\Admin\Factory\Admin\AdminServiceDelegator::class,
            ]
        ],
    ],
];
