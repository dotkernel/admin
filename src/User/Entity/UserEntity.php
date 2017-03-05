<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/18/2016
 * Time: 9:27 PM
 */

namespace Admin\User\Entity;

use Admin\User\Hydrator\UserHydrator;

/**
 * Class UserEntity
 * @package Dot\Authentication\Admin\Entity
 */
class UserEntity extends \Dot\User\Entity\UserEntity
{
    /** @var bool  */
    protected $needsPasswordRehash = true;

    /** @var  string */
    protected $hydrator = UserHydrator::class;

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
    public function jsonSerialize(): array
    {
        return array_merge(
            parent::jsonSerialize(),
            [
                'details' => $this->getDetails(),
            ]
        );
    }

    /**
     * @param bool|null $value
     * @return mixed
     */
    public function needsPasswordRehash(bool $value = null)
    {
        if ($value !== null) {
            $this->needsPasswordRehash = $value;
            return $this;
        } else {
            return $this->needsPasswordRehash;
        }
    }
}
