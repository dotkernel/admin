<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/21/2016
 * Time: 9:55 PM
 */

namespace Admin\User\Service;

use Admin\App\Exception\InvalidArgumentException;
use Admin\App\Service\AbstractEntityService;
use Admin\User\Entity\UserEntity;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;
use Zend\Crypt\Password\PasswordInterface;

/**
 * Class UserService
 * @package Dot\Authentication\Service
 *
 * @Service
 */
class UserService extends AbstractEntityService
{
    /** @var  string */
    protected $entityClass = UserEntity::class;

    /** @var  PasswordInterface */
    protected $passwordService;

    /**
     * @param UserEntity $entity
     * @param array $options
     * @return UserEntity
     */
    public function save($entity, array $options = [])
    {
        if (!$entity instanceof UserEntity) {
            throw new InvalidArgumentException('UserService can save only instances of UserEntity');
        }

        /** @var UserEntity $entity */
        if ($entity->needsPasswordRehash()) {
            $entity->setPassword($this->passwordService->create($entity->getPassword()));
        }

        $entity->needsPasswordRehash(true);

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
     *
     * @Inject({PasswordInterface::class})
     */
    public function setPasswordService(PasswordInterface $passwordService)
    {
        $this->passwordService = $passwordService;
        return $this;
    }
}
