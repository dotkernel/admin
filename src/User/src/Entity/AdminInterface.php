<?php

namespace Frontend\User\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

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
    public function getIdentity(): string;

    /**
     * @param string $identity
     */
    public function setIdentity(string $identity): void;

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
     * @param AdminRole $role
     * @return AdminInterface
     */
    public function addRole(AdminRole $role): AdminInterface;

    /**
     * @param AdminRole $role
     * @return AdminInterface
     */
    public function removeRole(AdminRole $role): AdminInterface;
}
