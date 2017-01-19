<?php

return [

    'dependencies' => [
        //whatever dependencies you need additionally
        'factories' => [
            \Dot\Admin\Authentication\Listener\AuthenticationListener::class =>
                \Zend\ServiceManager\Factory\InvokableFactory::class,
        ],
    ],

    'dot_user' => [
        //listeners for various user related events
        'user_event_listeners' => [

        ],

        //user entity and its hydrator to use for user transactions
        'user_entity' => \Dot\Admin\Entity\AdminEntity::class,

        'enable_user_status' => true,

        //enable user form label display
        'show_form_input_labels' => true,

        //db config
        'db_options' => [
            'db_adapter' => 'database',

            'user_table' => 'admin',
        ],

        //disable registration, we are not interested in other options
        'register_options' => [
            'enable_registration' => false,
        ],

        'login_options' => [
            'enable_remember_me' => false,

            'auth_identity_fields' => ['username', 'email'],

            'allowed_login_statuses' => ['active'],
        ],

        'password_recovery_options' => [
            'enable_password_recovery' => false,

            //'reset_password_token_timeout' => 3600,
        ],

        'confirm_account_options' => [
            'enable_account_confirmation' => false,

            //'active_user_status' => 'active'
        ],

        'template_options' => [
            'login_template' => 'app::login'
        ],

        'form_manager' => [
            'factories' => [

            ]
        ],

        'messages_options' => [
            'messages' => [

            ]
        ],
    ],

    'dot_authentication' => [
        //this package specific configuration template
        'web' => [
            //template name to use for the login form
            'login_template' => 'app::login',

            //where to redirect after login success
            'after_login_route' => 'dashboard',
            //where to redirect after logging out
            'after_logout_route' => 'login',
        ]
    ],
];
