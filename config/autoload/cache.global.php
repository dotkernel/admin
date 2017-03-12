<?php

return [
    'annotations_cache_dir' => __DIR__ . '/../../data/cache/annotations',

    'dependencies' => [
        'factories' => [
            // used by dot-annotated-services to cache annotations
            // needs to return a cache instance from Doctrine\Common\Cache
            \Dot\AnnotatedServices\Factory\AbstractAnnotatedFactory::CACHE_SERVICE =>
                \Admin\App\Factory\AnnotationsCacheFactory::class,
        ]
    ],
];
