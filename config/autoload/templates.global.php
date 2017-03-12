<?php

return [
    'dependencies' => [
        'factories' => [
            'Zend\Expressive\FinalHandler' =>
                Zend\Expressive\Container\TemplatedErrorHandlerFactory::class,

            Zend\Expressive\Template\TemplateRendererInterface::class =>
                Zend\Expressive\Twig\TwigRendererFactory::class,

            Twig_Environment::class =>
                \Zend\Expressive\Twig\TwigEnvironmentFactory::class,
        ],
    ],

    'templates' => [
        'extension' => 'html.twig',
        'paths' => [
            'app' => [__DIR__ . '/../../templates/app'],
            'layout' => [__DIR__ . '/../../templates/layout'],
            'error' => [__DIR__ . '/../../templates/error'],
            'partial' => [__DIR__ . '/../../templates/partial'],
            'admin' => [__DIR__ . '/../../templates/app/admin'],
            'user' => [__DIR__ . '/../../templates/app/user'],
        ],
    ],

    'twig' => [
        'cache_dir' => __DIR__ . '/../../data/cache/twig',
        'assets_url' => '/',
        'assets_version' => null,
        'extensions' => [
            // extension service names or instances
        ],
    ],
];
