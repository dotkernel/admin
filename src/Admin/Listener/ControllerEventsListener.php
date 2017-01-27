<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 1/27/2017
 * Time: 11:04 PM
 */

namespace Dot\Admin\Listener;

use Dot\Controller\Event\AbstractControllerEventListener;
use Dot\Controller\Event\ControllerEvent;

/**
 * Class ControllerEventsListener
 * @package Dot\Admin\Listener
 */
class ControllerEventsListener extends AbstractControllerEventListener
{
    public function onDispatch(ControllerEvent $e)
    {
        // this is called on every admin controller, when dispatching to the matched action
        // do something here, like logging, etc.
    }
}
