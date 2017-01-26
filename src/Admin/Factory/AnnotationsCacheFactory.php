<?php
/**
 * Created by PhpStorm.
 * User: n3vra
 * Date: 1/21/2017
 * Time: 5:36 PM
 */

namespace Dot\Admin\Factory;

use Doctrine\Common\Cache\FilesystemCache;
use Interop\Container\ContainerInterface;

/**
 * Class AnnotationsCacheFactory
 * @package Dot\Frontend\Factory
 */
class AnnotationsCacheFactory
{
    /**
     * @param ContainerInterface $container
     * @return FilesystemCache
     */
    public function __invoke(ContainerInterface $container)
    {
        //change this to suite your caching needs
        //this is used only to cache doctrine annotations for lib dot-annotated-services
        return new FilesystemCache($container->get('config')['annotations_cache_dir']);
    }
}
