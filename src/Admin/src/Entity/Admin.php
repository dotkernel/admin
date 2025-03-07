<?php

declare(strict_types=1);

namespace Admin\Admin\Entity;

use Admin\Admin\Enum\AdminStatusEnum;
use Admin\Admin\Repository\AdminRepository;
use Admin\App\Entity\AbstractEntity;
use Admin\App\Entity\TimestampsTrait;
use Admin\Setting\Entity\Setting;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use function array_map;
use function password_verify;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ORM\Table(name: 'admin')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Cache(usage: 'NONSTRICT_READ_WRITE')]
class Admin extends AbstractEntity implements AdminInterface
{
    use TimestampsTrait;

    #[ORM\Column(name: 'identity', type: 'string', length: 100, unique: true)]
    protected string $identity;

    #[ORM\Column(name: 'firstName', type: 'string', length: 255, nullable: true)]
    protected ?string $firstName = null;

    #[ORM\Column(name: 'lastName', type: 'string', length: 255, nullable: true)]
    protected ?string $lastName = null;

    #[ORM\Column(name: 'password', type: 'string', length: 100)]
    protected string $password;

    #[ORM\Column(type: 'admin_status_enum', name: 'status', options: ['default' => AdminStatusEnum::Active])]
    protected AdminStatusEnum $status = AdminStatusEnum::Active;

    #[ORM\ManyToMany(targetEntity: AdminRole::class, fetch: 'EAGER')]
    #[ORM\JoinTable(name: 'admin_roles')]
    #[ORM\JoinColumn(name: 'userUuid', referencedColumnName: 'uuid')]
    #[ORM\InverseJoinColumn(name: 'roleUuid', referencedColumnName: 'uuid')]
    protected Collection $roles;

    #[ORM\OneToMany(mappedBy: 'admin', targetEntity: Setting::class)]
    protected Collection $settings;

    public function __construct()
    {
        parent::__construct();

        $this->roles    = new ArrayCollection();
        $this->settings = new ArrayCollection();
    }

    public function getArrayCopy(): array
    {
        return [
            'uuid'      => $this->getUuid()->toString(),
            'identity'  => $this->getIdentity(),
            'firstName' => $this->getfirstName(),
            'lastName'  => $this->getlastName(),
            'status'    => $this->getStatus()->value,
            'roles'     => array_map(function (AdminRole $role) {
                return $role->getArrayCopy();
            }, $this->getRoles()),
            'created'   => $this->getCreated(),
            'updated'   => $this->getUpdated(),
        ];
    }

    public function getIdentity(): string
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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->getPassword());
    }

    public function getStatus(): AdminStatusEnum
    {
        return $this->status;
    }

    public function setStatus(AdminStatusEnum $status): self
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

    public function hasRole(AdminRole $role): bool
    {
        return $this->roles->contains($role);
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

    public function isActive(): bool
    {
        return $this->getStatus() === AdminStatusEnum::Active;
    }
}
