<?php
/**
 * @see https://github.com/dotkernel/dot-admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-admin/blob/master/LICENSE.md MIT License
 */

namespace Admin\App\Factory;

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
