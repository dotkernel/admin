<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 10/26/2016
 * Time: 7:38 PM
 */

namespace Dot\Admin\Admin\Entity;

use Dot\User\Entity\UserEntity;

/**
 * Class AdminEntity
 * @package Dot\Admin\Admin\Entity
 */
class AdminEntity extends UserEntity
{
    /** @var  string */
    protected $firstName;

    /** @var  string */
    protected $lastName;

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return AdminEntity
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return AdminEntity
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }


}
