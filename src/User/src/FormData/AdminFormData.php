<?php

declare(strict_types=1);

namespace Frontend\User\FormData;

use Frontend\User\Entity\Admin;
use Frontend\User\Entity\AdminRole;

/**
 * Class AdminFormData
 * @package Frontend\User\FormData
 */
class AdminFormData
{
    public ?string $identity = null;
    public ?string $firstName = null;
    public ?string $lastName = null;
    public ?string $status = null;
    public array $roles = [];

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param Admin|object $admin
     */
    public function fromEntity(Admin $admin): void
    {
        /** @var AdminRole $role */
        foreach ($admin->getRoles() as $role) {
            $this->roles[] = $role->getUuid()->toString();
        }
        $this->identity = $admin->getIdentity();
        $this->firstName = $admin->getFirstName();
        $this->lastName = $admin->getLastName();
        $this->status = $admin->getStatus();
    }

    /**
     * @return array
     */
    public function getArrayCopy(): array
    {
        return [
            'identity' => $this->identity,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'status' => $this->status,
            'roles' => $this->roles
        ];
    }
}
