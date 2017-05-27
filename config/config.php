<?php

use Zend\ConfigAggregator\ArrayProvider;
use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\PhpFileProvider;

// To enable or disable caching, set the `ConfigAggregator::ENABLE_CACHE` boolean in
// `config/autoload/local.php`.
$cacheConfig = [
    'config_cache_path' => __DIR__ . '/../data/config-cache.php',
];
$aggregator = new ConfigAggregator([
    // Include cache configuration
    new ArrayProvider($cacheConfig),

    //zend framework configs
    \Zend\Db\ConfigProvider::class,
    \Zend\Mail\ConfigProvider::class,

    // dotkernel components default configs
    // some of these configs are overwriting and customizing the underlying zendframework configs
    // in case the dotkernel package is heavily based on a zendframework package
    // you should not include both zendframework config provider and dotkernel's config provider in this case
    // e.g: dot-filter, dot-paginator, dot-session etc.
    \Dot\AnnotatedServices\ConfigProvider::class,
    \Dot\Authentication\ConfigProvider::class,
    \Dot\Authentication\Web\ConfigProvider::class,
    \Dot\Cache\ConfigProvider::class,
    \Dot\Controller\ConfigProvider::class,
    \Dot\Controller\Plugin\Authentication\ConfigProvider::class,
    \Dot\Controller\Plugin\Authorization\ConfigProvider::class,
    \Dot\Controller\Plugin\FlashMessenger\ConfigProvider::class,
    \Dot\Controller\Plugin\Mail\ConfigProvider::class,
    \Dot\Controller\Plugin\Forms\ConfigProvider::class,
    \Dot\Controller\Plugin\Session\ConfigProvider::class,
    \Dot\Mapper\ConfigProvider::class,
    \Dot\Event\ConfigProvider::class,
    \Dot\Filter\ConfigProvider::class,
    \Dot\FlashMessenger\ConfigProvider::class,
    \Dot\Form\ConfigProvider::class,
    \Dot\Helpers\ConfigProvider::class,
    \Dot\Hydrator\ConfigProvider::class,
    \Dot\InputFilter\ConfigProvider::class,
    \Dot\Log\ConfigProvider::class,
    \Dot\Mail\ConfigProvider::class,
    \Dot\Navigation\ConfigProvider::class,
    \Dot\Paginator\ConfigProvider::class,
    \Dot\Rbac\ConfigProvider::class,
    \Dot\Rbac\Guard\ConfigProvider::class,
    \Dot\Session\ConfigProvider::class,
    \Dot\Twig\ConfigProvider::class,
    \Dot\User\ConfigProvider::class,
    \Dot\Validator\ConfigProvider::class,
    \Dot\Console\ConfigProvider::class,

    //application
    \Admin\Admin\ConfigProvider::class,
    \Admin\User\ConfigProvider::class,
    \Admin\App\ConfigProvider::class,
    \Admin\Console\ConfigProvider::class,

    // Load application config in a pre-defined order in such a way that local settings
    // overwrite global settings. (Loaded as first to last):
    //   - `global.php`
    //   - `*.global.php`
    //   - `local.php`
    //   - `*.local.php`
    new PhpFileProvider('config/autoload/{{,*.}global,{,*.}local}.php'),

    // Load development config if it exists
    new PhpFileProvider('config/development.config.php'),
], $cacheConfig['config_cache_path']);

return $aggregator->getMergedConfig();
