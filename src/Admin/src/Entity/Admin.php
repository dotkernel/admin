<?php

declare(strict_types=1);

namespace Frontend\Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Frontend\Admin\Repository\AdminRepository;
use Frontend\App\Entity\AbstractEntity;

use function array_map;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ORM\Table(name: "admin")]
#[ORM\HasLifecycleCallbacks]
class Admin extends AbstractEntity implements AdminInterface
{
    public const STATUS_ACTIVE   = 'active';
    public const STATUS_INACTIVE = 'pending';
    public const STATUSES        = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
    ];

    #[ORM\Column(name: "identity", type: "string", length: 100, unique: true, nullable: false)]
    protected ?string $identity = null;

    #[ORM\Column(name: "firstName", type: "string", length: 255)]
    protected ?string $firstName = null;

    #[ORM\Column(name: "lastName", type: "string", length: 255)]
    protected ?string $lastName = null;

    #[ORM\Column(name: "password", type: "string", length: 100, nullable: false)]
    protected ?string $password = null;

    #[ORM\Column(
        name: "status",
        type: "string",
        length: 20,
        nullable: false,
        columnDefinition: "ENUM('pending', 'active')"
    )]
    protected string $status = self::STATUS_ACTIVE;

    #[ORM\ManyToMany(targetEntity: AdminRole::class, fetch: "EAGER")]
    #[ORM\JoinTable(name: "admin_roles")]
    #[ORM\JoinColumn(name: "userUuid", referencedColumnName: "uuid")]
    #[ORM\InverseJoinColumn(name: "roleUuid", referencedColumnName: "uuid")]
    protected Collection $roles;

    public function __construct()
    {
        parent::__construct();

        $this->roles = new ArrayCollection();
    }

    public function getArrayCopy(): array
    {
        return [
            'uuid'      => $this->getUuid()->toString(),
            'identity'  => $this->getIdentity(),
            'firstName' => $this->getfirstName(),
            'lastName'  => $this->getlastName(),
            'status'    => $this->getStatus(),
            'roles'     => array_map(function (AdminRole $role) {
                return $role->getArrayCopy();
            }, $this->getRoles()),
            'created'   => $this->getCreated(),
            'updated'   => $this->getUpdated(),
        ];
    }

    public function getIdentity(): ?string
    {
        return $this->identity;
    }

    public function setIdentity(string $identity): self
    {
        $this->identity = $identity;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles->toArray();
    }

    public function setRoles(ArrayCollection $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole(AdminRole $role): self
    {
        if (! $this->roles->contains($role)) {
            $this->roles->add($role);
        }

        return $this;
    }

    public function removeRole(AdminRole $role): AdminInterface
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }
}
