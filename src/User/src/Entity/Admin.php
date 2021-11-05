<?php

declare(strict_types=1);

namespace Frontend\User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Frontend\App\Entity\AbstractEntity;

use function array_map;

/**
 * Class Admin
 * @ORM\Entity(repositoryClass="Frontend\User\Repository\AdminRepository")
 * @ORM\Table(name="admin")
 * @ORM\HasLifecycleCallbacks()
 * @package Frontend\User\Entity
 */
class Admin extends AbstractEntity implements AdminInterface
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE
    ];

    /**
     * @ORM\Column(name="identity", type="string", length=100, nullable=false, unique=true)
     * @var string $identity
     */
    protected string $identity;

    /**
     * @ORM\Column(name="firstName", type="string", length=255)
     * @var $firstName
     */
    protected $firstName;

    /**
     * @ORM\Column(name="lastName", type="string", length=255)
     * @var $lastName
     */
    protected $lastName;

    /**
     * @ORM\Column(name="password", type="string", length=100, nullable=false)
     * @var string $password
     */
    protected string $password;

    /**
     * @ORM\Column(name="status", type="string", length=20, columnDefinition="ENUM('pending', 'active')")
     * @var string $status
     */
    protected string $status = self::STATUS_ACTIVE;

    /**
     * @ORM\ManyToMany(targetEntity="Frontend\User\Entity\AdminRole", fetch="EAGER")
     * @ORM\JoinTable(
     *     name="admin_roles",
     *     joinColumns={@ORM\JoinColumn(name="userUuid", referencedColumnName="uuid")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="roleUuid", referencedColumnName="uuid")}
     * )
     * @var ArrayCollection $roles
     */
    protected $roles = [];

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
     */
    public function setIdentity(string $identity): void
    {
        $this->identity = $identity;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
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
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
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
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return array|mixed
     */
    public function getRoles(): array
    {
        return $this->roles->toArray();
    }

    /**
     * @param ArrayCollection $roles
     */
    public function setRoles(ArrayCollection $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @param AdminRole $role
     * @return AdminInterface
     */
    public function addRole(AdminRole $role): AdminInterface
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
