<?php

use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\Glob;

/**
 * Configuration files are loaded in a specific order. First ``global.php``, then ``*.global.php``.
 * then ``local.php`` and finally ``*.local.php``. This way local settings overwrite global settings.
 *
 * The configuration can be cached. This can be done by setting ``config_cache_enabled`` to ``true``.
 *
 * Obviously, if you use closures in your config you can't cache it.
 */

$cachedConfigFile = __DIR__ . '/../data/cache/app_config.php';
$cachedConfigFile = __DIR__ . '/../data/cache/app_config.php';
if (!is_dir(__DIR__ . '/../data/cache')) {
    mkdir(__DIR__ . '/../data/cache');
    chmod(__DIR__ . '/../data/cache', 755);
}

$configManager = new \Zend\Expressive\ConfigManager\ConfigManager([
    //*************************************
    //zend framework enabled modules, might come in handy to have all these services in the DI
    //zend-db dependencies, as we use it
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

    new \Zend\Expressive\ConfigManager\PhpFileProvider(__DIR__ . '/autoload/{{,*.}global,{,*.}local}.php'),
], $cachedConfigFile);

return new ArrayObject($configManager->getMergedConfig());
