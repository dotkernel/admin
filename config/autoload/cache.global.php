<?php

use Dot\AnnotatedServices\Factory\AbstractAnnotatedFactory;
use Admin\App\Factory\AnnotationsCacheFactory;

return [
    'annotations_cache_dir' => __DIR__ . '/../../data/cache/annotations',

    'dependencies' => [
        'factories' => [
            // used by dot-annotated-services to cache annotations
            // needs to return a cache instance from Doctrine\Common\Cache
            AbstractAnnotatedFactory::CACHE_SERVICE => AnnotationsCacheFactory::class,
        ]
    ],
];
