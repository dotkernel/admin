<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/21/2016
 * Time: 9:56 PM
 */

namespace Dot\Admin\Service;

use Dot\Admin\Entity\Admin\AdminEntity;
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
     * @param $entity
     * @return int
     */
    public function save($entity)
    {
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
