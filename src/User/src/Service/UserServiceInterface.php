<?php

namespace Frontend\User\Service;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Frontend\User\Entity\User;
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
     * @throws NonUniqueResultException
     * @throws OptimisticLockException
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
    ): array;

    /**
     * @param string $identity
     * @return bool
     */
    public function exists(string $identity = '');

    /**
     * @param array $params
     * @return User|null
     */
    public function findOneBy(array $params = []): ?User;

    /**
     * @param string $email
     * @return array
     * @throws NonUniqueResultException
     */
    public function getRoleNamesByEmail(string $email): array;

    /**
     * @return array
     */
    public function getAdminFormProcessedRoles(): array;

    /**
     * @return array
     */
    public function getUserFormProcessedRoles(): array;
}
