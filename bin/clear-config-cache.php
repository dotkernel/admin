<?php
/**
 * Script for clearing the configuration cache.
 *
 * Can also be invoked as `composer clear-config-cache`.
 *
 * @see https://github.com/dotkernel/dot-admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-admin/blob/master/LICENSE.md MIT License
 */

chdir(__DIR__ . '/../');
require 'vendor/autoload.php';
$config = include 'config/config.php';
if (!isset($config['config_cache_path'])) {
    echo "No configuration cache path found" . PHP_EOL;
    exit(0);
}
if (!file_exists($config['config_cache_path'])) {
    printf(
        "Configured config cache file '%s' not found%s",
        $config['config_cache_path'],
        PHP_EOL
    );
    exit(0);
}
if (false === unlink($config['config_cache_path'])) {
    printf(
        "Error removing config cache file '%s'%s",
        $config['config_cache_path'],
        PHP_EOL
    );
    exit(1);
}
printf(
    "Removed configured config cache file '%s'%s",
    $config['config_cache_path'],
    PHP_EOL
);
exit(0);
