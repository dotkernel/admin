<?php

declare(strict_types=1);

namespace Frontend\User\Entity;

/**
 * Interface UserInterface
 * @package Frontend\User\Entity
 */
interface UserInterface
{
    /**
     * @return UserDetail|null
     */
    public function getDetail(): ?UserDetail;

    /**
     * @param UserDetail $detail
     * @return UserInterface
     */
    public function setDetail(UserDetail $detail): UserInterface;

    /**
     * @return UserAvatar|null
     */
    public function getAvatar(): ?UserAvatar;

    /**
     * @param UserAvatar $avatar
     * @return UserInterface
     */
    public function setAvatar(UserAvatar $avatar): UserInterface;

    /**
     * @return string
     */
    public function getIdentity(): string;

    /**
     * @param string $identity
     * @return UserInterface
     */
    public function setIdentity(string $identity): UserInterface;

    /**
     * @return string
     */
    public function getPassword(): string;

    /**
     * @param string $password
     * @return UserInterface
     */
    public function setPassword(string $password): UserInterface;

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @param string $status
     * @return UserInterface
     */
    public function setStatus(string $status): UserInterface;

    /**
     * @return mixed
     */
    public function getRoles(): array;

    /**
     * @param UserRole $role
     * @return UserInterface
     */
    public function addRole(UserRole $role): UserInterface;

    /**
     * @param UserRole $role
     * @return UserInterface
     */
    public function removeRole(UserRole $role): UserInterface;

    /**
     * @return array
     */
    public function getArrayCopy(): array;

    /**
     * @return UserInterface
     */
    public function activate();
}
