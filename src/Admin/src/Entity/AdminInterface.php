<?php

declare(strict_types=1);

namespace Frontend\Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Interface AdminInterface
 * @ORM\Entity(repositoryClass="Frontend\Admin\Repository\AdminRepository")
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
     * @return self
     */
    public function setIdentity(string $identity): self;

    /**
     * @return string
     */
    public function getFirstName(): string;

    /**
     * @param string $firstName
     * @return self
     */
    public function setFirstName(string $firstName): self;

    /**
     * @return string
     */
    public function getLastName(): string;

    /**
     * @param string $lastName
     * @return self
     */
    public function setLastName(string $lastName): self;

    /**
     * @return string
     */
    public function getPassword(): string;

    /**
     * @param string $password
     * @return self
     */
    public function setPassword(string $password): self;

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @param string $status
     * @return self
     */
    public function setStatus(string $status): self;

    /**
     * @return array
     */
    public function getRoles(): array;

    /**
     * @param ArrayCollection $roles
     * @return self
     */
    public function setRoles(ArrayCollection $roles): self;

    /**
     * @param AdminRole $role
     * @return self
     */
    public function addRole(AdminRole $role): self;

    /**
     * @param AdminRole $role
     * @return self
     */
    public function removeRole(AdminRole $role): self;
}
