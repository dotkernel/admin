<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/18/2016
 * Time: 9:27 PM
 */

namespace Dot\Admin\Entity\User;

use Dot\Ems\Entity\IgnorePropertyProvider;
use Dot\Ems\Entity\SearchableColumnsProvider;
use Dot\Ems\Entity\SortableColumnsProvider;

/**
 * Class UserEntity
 * @package Dot\Authentication\User\Entity
 */
class UserEntity extends \Dot\User\Entity\UserEntity implements
    \JsonSerializable,
    IgnorePropertyProvider,
    SortableColumnsProvider,
    SearchableColumnsProvider
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
        return ['roles', 'name', 'dateCreated'];
    }

    public function sortableColumns()
    {
        return ['id', 'username', 'email', 'dateCreated', 'role', 'status'];
    }

    public function searchableColumns()
    {
        return ['id', 'username', 'email', 'role', 'status'];
    }
}
