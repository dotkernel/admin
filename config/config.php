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

    //zend framework enabled modules
    \Zend\Db\ConfigProvider::class,
    \Zend\Filter\ConfigProvider::class,
    \Zend\Hydrator\ConfigProvider::class,
    \Zend\InputFilter\ConfigProvider::class,
    \Zend\Session\ConfigProvider::class,
    \Zend\Validator\ConfigProvider::class,
    \Zend\Form\ConfigProvider::class,
    \Zend\Mail\ConfigProvider::class,
    \Zend\Paginator\ConfigProvider::class,

    //dk modules config providers
    \Dot\Event\ConfigProvider::class,
    \Dot\FlashMessenger\ConfigProvider::class,
    \Dot\Helpers\ConfigProvider::class,
    \Dot\Mail\ConfigProvider::class,
    \Dot\Ems\ConfigProvider::class,
    \Dot\Navigation\ConfigProvider::class,
    \Dot\Authentication\ConfigProvider::class,
    \Dot\Authentication\Web\ConfigProvider::class,
    \Dot\Controller\ConfigProvider::class,
    \Dot\Controller\Plugin\Authentication\ConfigProvider::class,
    \Dot\Controller\Plugin\Authorization\ConfigProvider::class,
    \Dot\Controller\Plugin\FlashMessenger\ConfigProvider::class,
    \Dot\Controller\Plugin\Mail\ConfigProvider::class,
    \Dot\Rbac\ConfigProvider::class,
    \Dot\Rbac\Guard\ConfigProvider::class,
    \Dot\Session\ConfigProvider::class,
    \Dot\Twig\ConfigProvider::class,
    \Dot\User\ConfigProvider::class,
    \Dot\Log\ConfigProvider::class,

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
