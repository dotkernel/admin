<?php

declare(strict_types=1);

use Dot\Twig\Extension\DateExtension;
use Dot\Twig\Extension\TranslationExtension;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Mezzio\Template\TemplateRendererInterface;
use Mezzio\Twig\TwigEnvironmentFactory;
use Mezzio\Twig\TwigRendererFactory;
use Twig\Environment;

return [
    'dependencies' => [
        'factories' => [
            DateExtension::class             => InvokableFactory::class,
            Environment::class               => TwigEnvironmentFactory::class,
            TemplateRendererInterface::class => TwigRendererFactory::class,
            TranslationExtension::class      => InvokableFactory::class,
        ],
    ],
    'debug'        => false,
    'templates'    => [
        'extension' => 'html.twig',
    ],
    'twig'         => [
        'assets_url'      => '/',
        'assets_version'  => null,
        'auto_reload'     => true,
        'autoescape'      => 'html',
        'cache_dir'       => 'data/cache/twig',
        'extensions'      => [
            DateExtension::class,
            TranslationExtension::class,
        ],
        'globals'         => [
            'appName' => $app['name'] ?? '',
        ],
        'optimizations'   => -1,
        'runtime_loaders' => [],
//        'timezone'        => '',
    ],
];
