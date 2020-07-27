<?php

declare(strict_types=1);

namespace Frontend\User\FormData;

use Frontend\User\Entity\Admin;
use Frontend\User\Entity\AdminRole;

/**
 * Class AdminRoleData
 * @package Frontend\User\FormData
 */
class AdminRoleData
{
    public array $roles;

    public string $identity;

    public string $firstName;

    public string $lastName;

    public string $status;

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles ?? [];
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
     * @return array[]
     */
    public function getArrayCopy()
    {
        return [
            'roles' => $this->roles,
            'identity' => $this->identity,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'status' => $this->status
        ];
    }
}
