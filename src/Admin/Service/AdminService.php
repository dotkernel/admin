<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/21/2016
 * Time: 9:56 PM
 */

namespace Admin\User\Service;

use Admin\Admin\Entity\AdminEntity;
use Admin\App\Exception\InvalidArgumentException;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;
use Zend\Crypt\Password\PasswordInterface;

/**
 * Class AdminService
 * @package Dot\Authentication\Service
 *
 * @Service
 */
class AdminService extends AbstractEntityService
{
    /** @var  PasswordInterface */
    protected $passwordService;

    /**
     * @param AdminEntity $entity
     * @param array $options
     * @return AdminEntity
     */
    public function save($entity, array $options = [])
    {
        if (!$entity instanceof AdminEntity) {
            throw new InvalidArgumentException('AdminService can save only instances of AdminEntity');
        }

        /** @var AdminEntity $entity */
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
     *
     * @Inject({PasswordInterface::class})
     */
    public function setPasswordService(PasswordInterface $passwordService)
    {
        $this->passwordService = $passwordService;
        return $this;
    }
}
