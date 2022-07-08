<?php

declare(strict_types=1);

namespace Frontend\Admin\Doctrine;

use Frontend\Admin\Entity\Admin;

/**
 * Class AdminAuthentication
 * @package Frontend\Admin\Doctrine
 */
class AdminAuthentication
{
    /**
     * @param Admin $admin
     * @param $inputPassword
     * @return bool
     */
    public static function verifyCredential(Admin $admin, $inputPassword): bool
    {
        return password_verify($inputPassword, $admin->getPassword());
    }
}
