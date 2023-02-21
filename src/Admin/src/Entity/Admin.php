<?php

declare(strict_types=1);

namespace Frontend\Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Frontend\App\Entity\AbstractEntity;

/**
 * Class Admin
 * @ORM\Entity(repositoryClass="Frontend\Admin\Repository\AdminRepository")
 * @ORM\Table(name="admin")
 * @ORM\HasLifecycleCallbacks()
 * @package Frontend\Admin\Entity
 */
class Admin extends AbstractEntity implements AdminInterface
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'pending';
    public const STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE
    ];

    /**
     * @ORM\Column(name="identity", type="string", length=100, nullable=false, unique=true)
     */
    protected string $identity;

    /**
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    protected string $firstName;

    /**
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    protected string $lastName;

    /**
     * @ORM\Column(name="password", type="string", length=100, nullable=false)
     */
    protected string $password;

    /**
     * @ORM\Column(name="status", type="string", length=20, columnDefinition="ENUM('pending', 'active')")
     */
    protected string $status = self::STATUS_ACTIVE;

    /**
     * @ORM\ManyToMany(targetEntity="Frontend\Admin\Entity\AdminRole", fetch="EAGER")
     * @ORM\JoinTable(
     *     name="admin_roles",
     *     joinColumns={@ORM\JoinColumn(name="userUuid", referencedColumnName="uuid")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="roleUuid", referencedColumnName="uuid")}
     * )
     */
    protected Collection $roles;

    /**
     * Admin constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->roles = new ArrayCollection();
    }

    /**
     * @return array
     */
    public function getArrayCopy(): array
    {
        return [
            'uuid' => $this->getUuid()->toString(),
            'identity' => $this->getIdentity(),
            'firstName' => $this->getfirstName(),
            'lastName' => $this->getlastName(),
            'status' => $this->getStatus(),
            'roles' => array_map(function (AdminRole $role) {
                return $role->toArray();
            }, $this->getRoles()),
            'created' => $this->getCreated(),
            'updated' => $this->getUpdated()
        ];
    }

    /**
     * @return string
     */
    public function getIdentity(): string
    {
        return $this->identity;
    }

    /**
     * @param string $identity
     * @return self
     */
    public function setIdentity(string $identity): self
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return self
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return self
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return self
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles->toArray();
    }

    /**
     * @param ArrayCollection $roles
     * @return self
     */
    public function setRoles(ArrayCollection $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @param AdminRole $role
     * @return self
     */
    public function addRole(AdminRole $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
        }

        return $this;
    }

    /**
     * @param AdminRole $role
     * @return AdminInterface
     */
    public function removeRole(AdminRole $role): AdminInterface
    {
        if (!$this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }
}
