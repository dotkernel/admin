<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/21/2016
 * Time: 9:55 PM
 */

namespace Dot\Admin\Service;

use Dot\Admin\Entity\UserEntity;
use Zend\Crypt\Password\PasswordInterface;

/**
 * Class UserService
 * @package Dot\Authentication\Service
 */
class UserService extends AbstractEntityService
{
    /** @var  PasswordInterface */
    protected $passwordService;

    /**
     * @param $entity
     * @return int
     */
    public function save($entity)
    {
        /** @var UserEntity $entity */
        if (!empty($entity->getPassword())) {
            $entity->setPassword($this->passwordService->create($entity->getPassword()));
        }
        return parent::save($entity);
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
