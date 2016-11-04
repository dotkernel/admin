<?php

/**
 * This is a general place for things that needs to be run before application run
 * Use this mainly for event listener attachments, in case the module does not support listener attach through config
 */

/** @var \Zend\EventManager\EventManagerInterface $eventManager */
$eventManager = $container->get(\Zend\EventManager\EventManagerInterface::class);

/**
 * Register event listeners
 * This authentication listener prepares the request for authentication adapter
 */
/** @var  $authenticationListeners */
$authenticationListeners = $container->get(\Dot\Admin\Admin\Listener\AuthenticationListener::class);
$authenticationListeners->attach($eventManager);