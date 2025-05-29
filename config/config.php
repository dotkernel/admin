<?php

declare(strict_types=1);

// To enable or disable caching, set the `ConfigAggregator::ENABLE_CACHE` boolean in
// `config/autoload/local.php`.
$cacheConfig = [
    'config_cache_path' => 'data/cache/config-cache.php',
];

if (! class_exists('\Laminas\I18n\View\Helper\AbstractTranslatorHelper')) {
    class_alias(
        Admin\App\Laminas\I18n\View\Helper\AbstractTranslatorHelper::class,
        '\Laminas\I18n\View\Helper\AbstractTranslatorHelper'
    );
}
if (! class_exists('\Laminas\I18n\Validator\IsFloat')) {
    class_alias(Admin\App\Laminas\I18n\Validator\IsFloat::class, '\Laminas\I18n\Validator\IsFloat');
}

// @codingStandardsIgnoreStart
$aggregator = new Laminas\ConfigAggregator\ConfigAggregator([
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
    class_exists(Mezzio\Tooling\ConfigProvider::class)
        ? Mezzio\Tooling\ConfigProvider::class
        : function () {
        return [];
    },

    // Dotkernel packages
    Dot\Cache\ConfigProvider::class,
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
    Dot\Router\ConfigProvider::class,
    Dot\Session\ConfigProvider::class,
    Dot\Twig\ConfigProvider::class,

    // Include cache configuration
    new Laminas\ConfigAggregator\ArrayProvider($cacheConfig),

    // Dotkernel modules
    Admin\Admin\ConfigProvider::class,
    Admin\App\ConfigProvider::class,
    Admin\Dashboard\ConfigProvider::class,
    Admin\Page\ConfigProvider::class,
    Admin\Setting\ConfigProvider::class,
    Admin\User\ConfigProvider::class,
    Core\Admin\ConfigProvider::class,
    Core\App\ConfigProvider::class,
    Core\Security\ConfigProvider::class,
    Core\Setting\ConfigProvider::class,
    Core\User\ConfigProvider::class,

    // Load application config in a pre-defined order in such a way that local settings
    // overwrite global settings. (Loaded as first to last):
    //   - `global.php`
    //   - `*.global.php`
    //   - `local.php`
    //   - `*.local.php`
    //   - `local.test.php`
    new Laminas\ConfigAggregator\PhpFileProvider(
        realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local,{,*.}test}.php'
    ),

    // Load development config if it exists
    new Laminas\ConfigAggregator\PhpFileProvider(
        realpath(__DIR__) . '/development.config.php'
    ),
], $cacheConfig['config_cache_path']);
// @codingStandardsIgnoreEnd

return $aggregator->getMergedConfig();
