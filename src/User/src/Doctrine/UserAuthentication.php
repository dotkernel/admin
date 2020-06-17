<?php

declare(strict_types=1);

namespace Frontend\User\Doctrine;

use Frontend\User\Entity\User;

/**
 * Class UserAuthentication
 * @package Frontend\User\Doctrine
 */
class UserAuthentication
{
    public static function verifyCredential(User $user, $inputPassword)
    {
        return password_verify($inputPassword, $user->getPassword());
    }
}
