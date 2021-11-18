<?php

declare(strict_types=1);

use Twig\Environment;
use Mezzio\Twig\TwigEnvironmentFactory;
use Mezzio\Twig\TwigRendererFactory;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Mezzio\Template\TemplateRendererInterface;
use Dot\Twig\Extension\DateExtension;
use Dot\Twig\Extension\TranslationExtension;

return [
    'dependencies' => [
        'factories' => [
            Environment::class => TwigEnvironmentFactory::class,
            TemplateRendererInterface::class => TwigRendererFactory::class,
            DateExtension::class => InvokableFactory::class,
            TranslationExtension::class => InvokableFactory::class,
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
            TranslationExtension::class
        ],
        'optimizations' => -1,
        'runtime_loaders' => [],
        //'timezone' => '',
        'globals' => [
            'appName' => $app['name']
        ],
    ]
];
