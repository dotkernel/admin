<?php

declare(strict_types=1);

namespace Admin\User\Service;

use Admin\App\Exception\BadRequestException;
use Admin\App\Exception\ConflictException;
use Admin\App\Exception\NotFoundException;
use Core\User\Entity\User;
use Core\User\Repository\UserRepository;

interface UserServiceInterface
{
    public function getUserRepository(): UserRepository;

    public function deleteUser(User $user): User;

    /**
     * @throws NotFoundException
     */
    public function findUser(string $id): User;

    /**
     * @throws NotFoundException
     */
    public function findByEmail(string $email): User;

    /**
     * @throws NotFoundException
     */
    public function findByIdentity(string $identity): User;

    /**
     * @param non-empty-array<non-empty-string, mixed> $params
     * @throws NotFoundException
     */
    public function findOneBy(array $params): User;

    /**
     * @param non-empty-array<non-empty-string, mixed> $params
     * @return array<non-empty-string, mixed>
     */
    public function getUsers(array $params): array;

    /**
     * @param non-empty-array<non-empty-string, mixed> $data
     * @throws BadRequestException
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function saveUser(array $data, ?User $user = null): User;
}
