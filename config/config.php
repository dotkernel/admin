<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

// To enable or disable caching, set the `ConfigAggregator::ENABLE_CACHE` boolean in
// `config/autoload/local.php`.
$cacheConfig = [
    'config_cache_path' => 'data/cache/config-cache.php',
];

// @codingStandardsIgnoreStart
$aggregator = new ConfigAggregator([
    // Laminas packages
    Laminas\Diactoros\ConfigProvider::class,
    Laminas\Form\ConfigProvider::class,
    Laminas\HttpHandlerRunner\ConfigProvider::class,

    // Mezzio packages
    Mezzio\ConfigProvider::class,
    Mezzio\Cors\ConfigProvider::class,
    Mezzio\Helper\ConfigProvider::class,
    Mezzio\Router\ConfigProvider::class,
    Mezzio\Router\FastRouteRouter\ConfigProvider::class,
    Mezzio\Twig\ConfigProvider::class,

    // Dotkernel packages
    Dot\Cli\ConfigProvider::class,
    Dot\DataFixtures\ConfigProvider::class,
    Dot\DependencyInjection\ConfigProvider::class,
    Dot\ErrorHandler\ConfigProvider::class,
    Dot\FlashMessenger\ConfigProvider::class,
    Dot\GeoIP\ConfigProvider::class,
    Dot\Helpers\ConfigProvider::class,
    Dot\Log\ConfigProvider::class,
    Dot\Mail\ConfigProvider::class,
    Dot\Navigation\ConfigProvider::class,
    Dot\Rbac\ConfigProvider::class,
    Dot\Rbac\Guard\ConfigProvider::class,
    Dot\Session\ConfigProvider::class,
    Dot\Twig\ConfigProvider::class,
    Dot\Cache\ConfigProvider::class,

    // Include cache configuration
    new ArrayProvider($cacheConfig),

    // Dotkernel modules
    Admin\App\ConfigProvider::class,
    Admin\Admin\ConfigProvider::class,
    Admin\Setting\ConfigProvider::class,
    Admin\Page\ConfigProvider::class,
    Admin\Dashboard\ConfigProvider::class,

    Core\App\ConfigProvider::class,
    Core\Admin\ConfigProvider::class,
    // Load application config in a pre-defined order in such a way that local settings
    // overwrite global settings. (Loaded as first to last):
    //   - `global.php`
    //   - `*.global.php`
    //   - `local.php`
    //   - `*.local.php`
    new PhpFileProvider(realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local,{,*.}test}.php'),

    // Load development config if it exists
    new PhpFileProvider(realpath(__DIR__) . '/development.config.php'),
], $cacheConfig['config_cache_path']);
// @codingStandardsIgnoreEnd

return $aggregator->getMergedConfig();
