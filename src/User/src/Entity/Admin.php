<?php

declare(strict_types=1);

namespace Frontend\User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Frontend\App\Entity\AbstractEntity;

use function array_map;

/**
 * Class Admin
 * @ORM\Entity(repositoryClass="Frontend\User\Repository\UserRepository")
 * @ORM\Table(name="admin")
 * @ORM\HasLifecycleCallbacks()
 * @package Frontend\Admin\Entity
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
     * @ORM\Column(name="username", type="string", length=100, nullable=false, unique=true)
     * @var string $username
     */
    protected string $username;

    /**
     * @ORM\Column(name="email", type="string", length=100, nullable=false, unique=true)
     * @var string $email
     */
    protected string $email;

    /**
     * @ORM\Column(name="firstname", type="string", length=255)
     * @var $firstname
     */
    protected $firstname;

    /**
     * @ORM\Column(name="lastname", type="string", length=255)
     * @var $lastname
     */
    protected $lastname;

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
     * @ORM\ManyToMany(targetEntity="Frontend\User\Entity\AdminRole")
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
            'username' => $this->getUsername(),
            'email' => $this->getEmail(),
            'firstname' => $this->getFirstname(),
            'lastname' => $this->getLastname(),
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
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
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
