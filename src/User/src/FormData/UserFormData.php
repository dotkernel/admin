<?php

declare(strict_types=1);

namespace Frontend\User\FormData;

use Frontend\User\Entity\User;

/**
 * Class UserFormData
 * @package Frontend\User\FormData
 */
class UserFormData
{
    /** @var string $identity */
    public string $identity;

    /** @var string $firstName */
    public string $firstName;

    /** @var string $lastName */
    public string $lastName;

    /** @var string $status */
    public string $status;

    /** @var array $roles */
    public array $roles;

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles ?? [];
    }

    /**
     * @param User|object $user
     */
    public function fromEntity(User $user)
    {
        foreach ($user->getRoles() as $role) {
            $this->roles[] = $role->getUuid()->toString();
        }
        $this->firstName = $user->getDetail()->getFirstName();
        $this->lastName = $user->getDetail()->getLastName();
        $this->identity = $user->getIdentity();
        $this->status = $user->getStatus();
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
            'status' => $this->status,
        ];
    }
}
