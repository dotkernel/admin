<?php

use Twig\Environment;
use Mezzio\Twig\TwigEnvironmentFactory;
use Mezzio\Twig\TwigRendererFactory;
use Twig\Extensions\I18nExtension;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Mezzio\Template\TemplateRendererInterface;
use Twig\Extensions\DateExtension;

return [
    'dependencies' => [
        'factories' => [
            Environment::class => TwigEnvironmentFactory::class,
            TemplateRendererInterface::class => TwigRendererFactory::class,
            DateExtension::class => InvokableFactory::class,
            I18nExtension::class => InvokableFactory::class,
        ],
    ],
    'debug' => false,
    'templates' => [
        'extension' => 'html.twig'
    ],
    'twig' => [
        'assets_url' => '/',
        'assets_version' => null,
        'autoescape' => 'html',
        'auto_reload' => true,
        'cache_dir' => 'data/cache/twig',
        'extensions' => [
            DateExtension::class,
            I18nExtension::class
        ],
        'optimizations' => -1,
        'runtime_loaders' => [],
        //'timezone' => '',
        'globals' => [
            'appName' => $app['name']
        ],
    ]
];
