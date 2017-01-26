<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 10/26/2016
 * Time: 7:38 PM
 */

namespace Dot\Admin\Entity\Admin;

use Dot\Ems\Entity\SearchableColumnsProvider;
use Dot\Ems\Entity\SortableColumnsProvider;
use Dot\User\Entity\UserEntity;

/**
 * Class AdminEntity
 * @package Dot\Authentication\Authentication\Entity
 */
class AdminEntity extends UserEntity implements
    SortableColumnsProvider,
    SearchableColumnsProvider
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
        return ['id', 'username', 'email', 'dateCreated', 'role', 'status', 'firstName', 'lastName'];
    }

    public function searchableColumns()
    {
        return ['id', 'username', 'email', 'firstName', 'lastName', 'role', 'status'];
    }
}
