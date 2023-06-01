<?php

declare(strict_types=1);

return [
    /**
     * dotkernel/dot-flashmessenger options
     * @see https://github.com/dotkernel/dot-flashmessenger
     */
    'dot_flashmessenger' => [
        'options' => [
            /**
             * FlashMessenger session container
             */
            'namespace' => 'admin_messenger',
        ]
    ],

    /**
     * dotkernel/dot-session options
     * @see https://github.com/dotkernel/dot-session
     */
    'dot_session' => [
        /**
         * Amount of seconds of inactivity for which the system will extend session.
         *
         * While the difference between now and LAST_ACTIVITY stored in session is less than rememberMeInactive,
         * the session will be extended => user will not be logged out due to inactivity.
         */
        'rememberMeInactive' => 1800,
    ],

    /**
     * laminas/laminas-session options
     * @see https://docs.laminas.dev/laminas-session/config/
     */
    'session_config' => [
        /**
         * Specifies the domain to set in the session cookie.
         */
        'cookie_domain' => '',

        /**
         * Marks the cookie as accessible only through the HTTP protocol.
         */
        'cookie_httponly' => true,

        /**
         * Specifies the lifetime of the cookie in seconds which is sent to the browser.
         */
        'cookie_lifetime' => 3600 * 24 * 30,

        /**
         * Specifies path to set in the session cookie.
         */
        'cookie_path' => '/',

        /**
         * Specifies whether cookies should be sent along with cross-site requests.
         */
        'cookie_samesite' => 'Lax',

        /**
         * Specifies whether cookies should only be sent over secure connections.
         */
        'cookie_secure' => false,

        /**
         * Specifies the name of the session which is used as cookie name.
         */
        'name' => 'ADMIN_SESSID',

        /**
         * Specifies how long to remember the session before clearing data.
         */
        'remember_me_seconds' => 3600 * 24 * 30,

        /**
         * Specifies whether the module will use cookies to store the session id.
         */
        'use_cookies' => true,
    ],
    /**
     * Allows creating Container instances.
     */
    'session_containers' => [
        'user',
    ],
];
