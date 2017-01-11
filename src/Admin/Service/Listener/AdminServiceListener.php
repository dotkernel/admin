<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 1/10/2017
 * Time: 9:09 PM
 */

namespace Dot\Admin\Service\Listener;

use Dot\Ems\Event\AbstractEntityServiceListener;
use Dot\Ems\Event\EntityServiceEvent;

/**
 * Class AdminServiceListener
 *
 * @package Dot\Admin\Service\Listener
 */
class AdminServiceListener extends AbstractEntityServiceListener
{
    /**
     * @param EntityServiceEvent $e
     * @return void
     */
    public function onPreCreate(EntityServiceEvent $e)
    {
        // TODO: Implement onPreCreate() method.
    }

    /**
     * @param EntityServiceEvent $e
     * @return void
     */
    public function onPostCreate(EntityServiceEvent $e)
    {
        // TODO: Implement onPostCreate() method.
    }

    /**
     * @param EntityServiceEvent $e
     * @return void
     */
    public function onCreateError(EntityServiceEvent $e)
    {
        // TODO: Implement onCreateError() method.
    }

    public function onPreUpdate(EntityServiceEvent $e)
    {
        // TODO: Implement onPreUpdate() method.
    }

    /**
     * @param EntityServiceEvent $e
     * @return void
     */
    public function onPostUpdate(EntityServiceEvent $e)
    {
        // TODO: Implement onPostUpdate() method.
    }

    /**
     * @param EntityServiceEvent $e
     * @return void
     */
    public function onUpdateError(EntityServiceEvent $e)
    {
        // TODO: Implement onUpdateError() method.
    }

    /**
     * @param EntityServiceEvent $e
     * @return void
     */
    public function onPreDelete(EntityServiceEvent $e)
    {
        // TODO: Implement onPreDelete() method.
    }

    /**
     * @param EntityServiceEvent $e
     * @return void
     */
    public function onPostDelete(EntityServiceEvent $e)
    {
        // TODO: Implement onPostDelete() method.
    }

    /**
     * @param EntityServiceEvent $e
     * @return void
     */
    public function onDeleteError(EntityServiceEvent $e)
    {
        // TODO: Implement onDeleteError() method.
    }
}
