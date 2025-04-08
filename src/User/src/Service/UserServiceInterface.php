<?php

declare(strict_types=1);

namespace Admin\User\Service;

use Core\App\Exception\BadRequestException;
use Core\App\Exception\ConflictException;
use Core\App\Exception\NotFoundException;
use Core\User\Entity\User;
use Core\User\Repository\UserRepository;

interface UserServiceInterface
{
    public function getUserRepository(): UserRepository;

    public function activateUser(User $user): User;

    /**
     * @throws BadRequestException
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function createUser(array $data = []): User;

    public function deactivateUser(User $user): User;

    public function deleteUser(User $user): User;

    /**
     * @throws NotFoundException
     */
    public function find(string $id): User;

    /**
     * @throws NotFoundException
     */
    public function findByEmail(string $email): User;

    public function findByIdentity(string $identity): ?User;

    /**
     * @throws NotFoundException
     */
    public function findOneBy(array $params): User;

    /**
     * @param array<string, mixed> $params
     */
    public function getUsers(array $params): array;

    /**
     * @throws BadRequestException
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function updateUser(User $user, array $data = []): User;
}
