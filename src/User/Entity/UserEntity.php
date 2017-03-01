<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/18/2016
 * Time: 9:27 PM
 */

namespace Admin\User\Entity;

/**
 * Class UserEntity
 * @package Dot\Authentication\Admin\Entity
 */
class UserEntity extends \Dot\User\Entity\UserEntity implements \JsonSerializable
{
    /** @var  UserDetailsEntity */
    protected $details;

    /**
     * @return UserDetailsEntity
     */
    public function getDetails()
    {
        if (!$this->details) {
            $this->details = new UserDetailsEntity();
        }
        return $this->details;
    }

    /**
     * @param UserDetailsEntity $details
     */
    public function setDetails(UserDetailsEntity $details)
    {
        $this->details = $details;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
