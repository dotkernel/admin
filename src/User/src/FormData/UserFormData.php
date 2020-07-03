<?php

declare(strict_types=1);

namespace Frontend\User\FormData;

use Frontend\User\Entity\User;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterAwareTrait;

/**
 * Class UserFormData
 * @package Frontend\User\FormData
 */
class UserFormData implements InputFilterAwareInterface
{
    use InputFilterAwareTrait;

    /** @var string $identity */
    public string $identity;

    /** @var string $firstName */
    public string $firstName;

    /** @var string $lastName */
    public string $lastName;

    /** @var string $status */
    public string $status;

    /** @var string $role */
    public string $role;

    /**
     * @param User $user
     * @return UserFormData
     */
    public static function fromUserEntity(User $user)
    {
        $data = new UserFormData();
        $data->firstName = $user->getDetail()->getFirstName();
        $data->lastName = $user->getDetail()->getLastName();
        $data->identity = $user->getIdentity();
        $data->status = $user->getStatus();
        $data->role = $user->getRoles()[0]->getUuid()->toString();

        return $data;
    }
}
