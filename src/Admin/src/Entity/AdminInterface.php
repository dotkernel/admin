<?php

declare(strict_types=1);

namespace Frontend\Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Interface AdminInterface
 *
 * @ORM\Entity(repositoryClass="Frontend\Admin\Repository\AdminRepository")
 * @ORM\Table(name="admin")
 * @ORM\HasLifecycleCallbacks()
 */
interface AdminInterface
{
    /**
     * @return array
     */
    public function getArrayCopy(): array;

    public function getIdentity(): string;

    public function setIdentity(string $identity): self;

    public function getFirstName(): string;

    public function setFirstName(string $firstName): self;

    public function getLastName(): string;

    public function setLastName(string $lastName): self;

    public function getPassword(): string;

    public function setPassword(string $password): self;

    public function getStatus(): string;

    public function setStatus(string $status): self;

    /**
     * @return array
     */
    public function getRoles(): array;

    public function setRoles(ArrayCollection $roles): self;

    public function addRole(AdminRole $role): self;

    public function removeRole(AdminRole $role): self;
}
