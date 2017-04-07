<?php
/**
 * @see https://github.com/dotkernel/admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/admin/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Admin\Admin\Entity;

use Admin\Admin\Hydrator\AdminHydrator;
use Dot\User\Entity\UserEntity;

/**
 * Class UserEntity
 * @package Admin\Admin\Entity
 */
class AdminEntity extends UserEntity
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_DELETED = 'deleted';

    /** @var  string */
    protected $hydrator = AdminHydrator::class;

    /** @var bool  */
    protected $needsPasswordRehash = true;

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
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
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
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $fields = parent::jsonSerialize();
        return array_merge($fields, [
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
        ]);
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
