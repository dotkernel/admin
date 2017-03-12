<?php

use Zend\Expressive\Application;
use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Helper;

return [
    'dependencies' => [
        'factories' => [
            Application::class => ApplicationFactory::class,
            Helper\UrlHelper::class => Helper\UrlHelperFactory::class,
            Helper\ServerUrlHelper::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
        ],

        'lazy_services' => [
            'proxies_target_dir' => 'data/proxies',
            'proxies_namespace' => 'DotProxy',
        ]
    ],
];
