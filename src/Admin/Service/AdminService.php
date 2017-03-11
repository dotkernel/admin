<?php
/**
 * @see https://github.com/dotkernel/dot-admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-admin/blob/master/LICENSE.md MIT License
 */

namespace Admin\Admin\Service;

use Admin\Admin\Entity\AdminEntity;
use Admin\App\Exception\InvalidArgumentException;
use Admin\App\Service\AbstractEntityService;
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
    /** @var  string */
    protected $entityClass = AdminEntity::class;

    /** @var  PasswordInterface */
    protected $passwordService;

    /** @var array  */
    protected $searchableColumns = ['id', 'username', 'email',
        'firstName', 'lastName', 'status'
    ];

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
