<?php

return [

    /**
     * Dk mail module configuration
     * Note that many of these options can be set programmaticaly too, when sending mail messages
     * actually that is what you'll usually do, these config provide just default and
     * options that remain the same for all mails
     */

    'dot_mail' => [
        //the key is the mail service name, this is the default one, which does not extends any configuration
        'default' => [
            //tells which other mail service configuration to extend
            'extends' => null,

            /**
             * the mail transport to use
             * can be any class implementing Zend\Mail\Transport\TransportInterface
             *
             * for standard mail transports, you can use these aliases
             * - sendmail => Zend\Mail\Transport\Sendmail
             * - smtp => Zend\Mail\Transport\Smtp
             * - file => Zend\Mail\Transport\File
             * - in_memory => Zend\Mail\Transport\InMemory
             *
             * defaults to sendmail
             **/

            'transport' => \Zend\Mail\Transport\Smtp::class,

            //message configuration
            'message_options' => [

                //from email address of the email
                'from' => 'support@dotkernel.com',

                //from name to be displayed instead of from address
                'from_name' => 'DotKernel Team',

                //reply-to email address of the email
                'reply_to' => '',

                //replyTo name to be displayed instead of the address
                'reply_to_name' => '',

                //destination email address as string or a list of email addresses
                'to' => [],

                //copy destination addresses
                'cc' => [],

                //hidden copy destination addresses
                'bcc' => [],

                //email subject
                'subject' => '',

                //body options - content can be plain text, HTML or a template to parse
                'body' => [
                    'content' => '',

                    'charset' => 'utf-8',

                    //enable if you want body content to come from a template
                    'use_template' => false,

                    //template options in case body has use template enabled
                    'template' => [
                        'name' => '',
                        'params' => [],
                    ],
                ],

                //attachments config
                'attachments' => [
                    'files' => [],

                    'dir' => [
                        'iterate' => false,
                        'path' => 'data/mail/attachments',
                        'recursive' => false,
                    ]
                ],
            ],

            //options that will be used only if Zend\Mail\Transport\Smtp adapter is used
            'smtp_options' => [

                //hostname or IP address of the mail server
                'host' => '',

                //port of the mail server - default 25
                'port' => 587,

                //connection class used for authentication
                //the calue can be one of smtp, plain, login or crammd5
                'connection_class' => 'login',

                'connection_config' => [

                    //the smtp authentication identity
                    //'username' => '',

                    //the smtp authentication credential
                    //'password' => '',

                    //the encryption type to be used, ssl or tls
                    //null should be used to disable SSL
                    'ssl' => 'tls',
                ]
            ],

            //file options that will be used only if the adapter is Zend\Mail\Transport\File
            /*'file_options' => [

                // this is the folder where the file is going to be saved
                // default value is 'data/mail/output'
                'path' => 'data/mail/output',

                // a callable that will get the Zend\Mail\Transport\File object as an argument
                // and should return the filename
                // if null is used, and empty callable will be used
                // 'callback' => null,
            ],*/

            //listeners to register with the mail service, for mail events
            'event_listeners' => [

            ],
        ],

        /**
         * You can define other mail services here, with the same structure as the defaul block
         * you can even extend from the default block, and overwrite only the differences
         */
    ],
];
