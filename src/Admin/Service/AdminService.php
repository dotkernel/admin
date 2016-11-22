<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/21/2016
 * Time: 9:56 PM
 */

namespace Dot\Admin\Service;

use Dot\Admin\Admin\Entity\AdminEntity;
use Dot\User\Service\PasswordInterface;

/**
 * Class AdminService
 * @package Dot\Admin\Service
 */
class AdminService extends AbstractEntityService
{
    /** @var  PasswordInterface */
    protected $passwordService;

    /**
     * @param $entity
     * @return int
     */
    public function save($entity)
    {
        /** @var AdminEntity $entity */
        if(!empty($entity->getPassword())) {
            $entity->setPassword($this->passwordService->create($entity->getPassword()));
        }
        return parent::save($entity);
    }

    /**
     * @param $ids
     * @return mixed
     */
    public function markAsDeleted($ids)
    {
        return $this->entityExtensionMapper->markAsDeleted($ids, 'status', 'deleted');
    }

    /**
     * @param array $ids
     * @return mixed
     */
    public function bulkDelete($ids)
    {
        return $this->entityExtensionMapper->bulkDelete($ids);
    }

    /**
     * @return PasswordInterface
     */
    public function getPasswordService()
    {
        return $this->passwordService;
    }

    /**
     * @param PasswordInterface $passwordService
     * @return $this
     */
    public function setPasswordService(PasswordInterface $passwordService)
    {
        $this->passwordService = $passwordService;
        return $this;
    }
}