<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 1/10/2017
 * Time: 9:09 PM
 */

namespace Dot\Admin\Service\Listener;

use Dot\Authentication\AuthenticationInterface;
use Dot\Ems\Event\AbstractEntityServiceListener;
use Dot\Ems\Event\EntityServiceEvent;
use Dot\Ems\Service\EntityService;
use Zend\Log\Logger;

/**
 * Class AdminServiceListener
 *
 * @package Dot\Admin\Service\Listener
 */
class AdminServiceListener extends AbstractEntityServiceListener
{
    /** @var  Logger */
    protected $actionLogger;

    /** @var  AuthenticationInterface */
    protected $authenticationService;

    /**
     * AdminServiceListener constructor.
     * @param Logger $actionLogger
     * @param AuthenticationInterface $authenticationService
     */
    public function __construct(Logger $actionLogger, AuthenticationInterface $authenticationService)
    {
        $this->actionLogger = $actionLogger;
        $this->authenticationService = $authenticationService;
    }

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
        /** @var EntityService $service */
        $service = $e->getTarget();
        $target = $e->getData();

        $extra = [
            'type' => 'create',
            'status' => 'ok',
        ];

        $this->actionLogger->info(
            'Entity created successfully',
            array_merge(
                $extra,
                $this->getConstantExtra(),
                $this->getTargetExtra($service, $target)
            )
        );
    }

    /**
     * @return array
     */
    protected function getConstantExtra()
    {
        return [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'agentId' => $this->authenticationService->hasIdentity()
                ? $this->authenticationService->getIdentity()->getId()
                : null,
            'agentName' => $this->authenticationService->hasIdentity()
                ? $this->authenticationService->getIdentity()->getName()
                : null,
        ];
    }

    /**
     * @param EntityService $service
     * @param $target
     * @return array
     */
    protected function getTargetExtra(EntityService $service, $target)
    {
        $targetId = null;
        if (is_object($target)) {
            $getter = 'get' . ucfirst($service->getMapper()->getIdentifierName());
            if (method_exists($target, $getter)) {
                $targetId = call_user_func([$target, $getter]);
            }
            $target = get_class($target);
        }

        return [
            'target' => $target,
            'targetId' => $targetId,
        ];
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
        /** @var EntityService $service */
        $service = $e->getTarget();
        $target = $e->getData();

        $extra = [
            'type' => 'update',
            'status' => 'ok',
        ];

        $this->actionLogger->info(
            'Entity updated successfully',
            array_merge(
                $extra,
                $this->getConstantExtra(),
                $this->getTargetExtra($service, $target)
            )
        );
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
