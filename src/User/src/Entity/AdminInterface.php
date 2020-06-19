<?php

namespace Frontend\User\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Admin
 * @ORM\Entity(repositoryClass="Frontend\User\Repository\UserRepository")
 * @ORM\Table(name="admin")
 * @ORM\HasLifecycleCallbacks()
 * @package Frontend\Admin\Entity
 */
interface AdminInterface
{
    /**
     * @return array
     */
    public function getArrayCopy(): array;

    /**
     * @return string
     */
    public function getUsername(): string;

    /**
     * @param string $username
     */
    public function setUsername(string $username): void;

    /**
     * @return string
     */
    public function getPassword(): string;

    /**
     * @param string $password
     */
    public function setPassword(string $password): void;

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @param string $status
     */
    public function setStatus(string $status): void;

    /**
     * @return array|mixed
     */
    public function getRoles(): array;

    /**
     * @param ArrayCollection $roles
     */
    public function setRoles(ArrayCollection $roles): void;

    /**
     * @param UserRole $role
     * @return \Frontend\User\Entity\AdminInterface
     */
    public function addRole(UserRole $role): AdminInterface;

    /**
     * @param UserRole $role
     * @return \Frontend\User\Entity\AdminInterface
     */
    public function removeRole(UserRole $role): AdminInterface;
}