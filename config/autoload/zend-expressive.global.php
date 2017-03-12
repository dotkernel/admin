<?php

use Zend\ConfigAggregator\ConfigAggregator;

return [
    // Enable debugging; typically used to provide debugging information within templates.
    'debug' => false,

    // Toggle the configuration cache. Set this to boolean false, or remove the
    // directive, to disable configuration caching. Toggling development mode
    // will also disable it by default; clear the configuration cache using
    // `composer clear-config-cache`.
    ConfigAggregator::ENABLE_CACHE => true,

    'zend-expressive' => [
        // Provide templates for the error handling middleware to use when
        // generating responses.
        'error_handler' => [
            'template_404' => 'error::404',
            'template_error' => 'error::error',
        ],
    ],

    'dependencies' => [
        'lazy_services' => [
            'write_proxy_files' => true,
        ]
    ]
];
