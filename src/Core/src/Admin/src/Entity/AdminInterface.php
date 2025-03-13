<?php

declare(strict_types=1);

namespace Core\Admin\Entity;

use Core\Admin\Enum\AdminStatusEnum;
use Doctrine\Common\Collections\ArrayCollection;

interface AdminInterface
{
    public function getArrayCopy(): array;

    public function getIdentity(): ?string;

    public function setIdentity(string $identity): self;

    public function getFirstName(): ?string;

    public function setFirstName(string $firstName): self;

    public function getLastName(): ?string;

    public function setLastName(string $lastName): self;

    public function getPassword(): ?string;

    public function setPassword(string $password): self;

    public function getStatus(): AdminStatusEnum;

    public function setStatus(AdminStatusEnum $status): self;

    public function getRoles(): array;

    public function setRoles(ArrayCollection $roles): self;

    public function addRole(AdminRole $role): self;

    public function removeRole(AdminRole $role): self;
}
