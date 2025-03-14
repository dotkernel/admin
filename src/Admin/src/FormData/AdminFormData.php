<?php

declare(strict_types=1);

namespace Admin\Admin\FormData;

use Core\Admin\Entity\Admin;
use Core\Admin\Entity\AdminRole;

use function array_map;

final class AdminFormData
{
    public ?string $identity  = null;
    public ?string $firstName = null;
    public ?string $lastName  = null;
    public ?string $status    = null;
    public array $roles       = [];

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function fromEntity(Admin $admin): self
    {
        $this->identity  = $admin->getIdentity();
        $this->firstName = $admin->getFirstName();
        $this->lastName  = $admin->getLastName();
        $this->status    = $admin->getStatus()->value;
        $this->roles     = array_map(function (AdminRole $role) {
            return [
                'label' => $role->getName(),
                'value' => $role->getUuid()->toString(),
            ];
        }, $admin->getRoles());

        return $this;
    }

    public function getArrayCopy(): array
    {
        return [
            'identity'  => $this->identity,
            'firstName' => $this->firstName,
            'lastName'  => $this->lastName,
            'status'    => $this->status,
            'roles'     => $this->roles,
        ];
    }
}
