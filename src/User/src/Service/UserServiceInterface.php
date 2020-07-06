<?php

namespace Frontend\User\Service;

use Doctrine\ORM\ORMException;
use Frontend\User\Entity\Admin;
use Frontend\User\Entity\UserInterface;
use Frontend\User\FormData\UserFormData;

/**
 * Interface UserServiceInterface
 * @package Frontend\Admin\Service
 */
interface UserServiceInterface
{
    /**
     * @param UserFormData $data
     * @return UserInterface
     * @throws ORMException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createUser(UserFormData $data): UserInterface;

    /**
     * @param int $offset
     * @param int $limit
     * @param string|null $search
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getUsers(
        int $offset = 0,
        int $limit = 30,
        string $search = null,
        string $sort = 'created',
        string $order = 'desc'
    );

    /**
     * @param string $identity
     * @return bool
     */
    public function exists(string $identity = '');

    /**
     * @param array $params
     * @return Admin|null
     */
    public function findOneBy(array $params = []): ?Admin;

    /**
     * @param string $email
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getRoleNamesByEmail(string $email);

    /**
     * @return array
     */
    public function getAdminFormProcessedRoles();

    /**
     * @return array
     */
    public function getUserFormProcessedRoles();
}
