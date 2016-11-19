<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/18/2016
 * Time: 9:27 PM
 */

namespace Dot\Admin\User\Entity;

use Dot\Ems\Entity\IgnorePropertyProvider;
use Dot\Ems\Entity\SortableColumnsProvider;

/**
 * Class UserEntity
 * @package Dot\Admin\User\Entity
 */
class UserEntity extends \Dot\User\Entity\UserEntity implements
    \JsonSerializable,
    IgnorePropertyProvider,
    SortableColumnsProvider
{
    /** @var  UserDetailsEntity */
    protected $details;

    /**
     * @return UserDetailsEntity
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param UserDetailsEntity $details
     * @return UserEntity
     */
    public function setDetails(UserDetailsEntity $details = null)
    {
        $this->details = $details;
        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * @return array
     */
    public function ignoredProperties()
    {
        return ['dateCreated'];
    }

    public function sortableColumns()
    {
        return ['username', 'email', 'dateCreated', 'role', 'status'];
    }
}