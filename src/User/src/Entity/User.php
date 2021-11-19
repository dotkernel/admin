<?php

declare(strict_types=1);

namespace Frontend\User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Frontend\App\Common\UuidOrderedTimeGenerator;
use Frontend\App\Entity\AbstractEntity;
use Throwable;

use function array_map;
use function bin2hex;
use function random_bytes;

/**
 * Class User
 * @ORM\Entity(repositoryClass="Frontend\User\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 * @package Frontend\User\Entity
 */
class User extends AbstractEntity implements UserInterface
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_ACTIVE = 'active';
    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_ACTIVE
    ];

    public const IS_DELETED_YES = 'yes';
    public const IS_DELETED_NO = 'no';

    /**
     * @ORM\OneToOne(targetEntity="Frontend\User\Entity\UserDetail", cascade={"persist", "remove"}, mappedBy="user")
     * @var UserDetail $detail
     */
    protected $detail;

    /**
     * @ORM\OneToOne(targetEntity="Frontend\User\Entity\UserAvatar", cascade={"persist", "remove"}, mappedBy="user")
     * @var UserAvatar $avatar
     */
    protected $avatar;

    /**
     * @ORM\Column(name="identity", type="string", length=191, nullable=false, unique=true)
     * @var string $identity
     */
    protected $identity;

    /**
     * @ORM\Column(name="password", type="string", length=191, nullable=false)
     * @var string $password
     */
    protected $password;

    /**
     * @ORM\Column(name="status", type="string", length=20, columnDefinition="ENUM('pending', 'active')")
     * @var string $status
     */
    protected $status = self::STATUS_PENDING;

    /**
     * @ORM\Column(name="isDeleted", type="string")
     * @var string $isDeleted
     */
    protected $isDeleted = self::IS_DELETED_NO;

    /**
     * @ORM\Column(name="hash", type="string", length=64, nullable=false, unique=true)
     * @var string $hash
     */
    protected $hash;

    /**
     * @ORM\ManyToMany(targetEntity="Frontend\User\Entity\UserRole")
     * @ORM\JoinTable(
     *     name="user_roles",
     *     joinColumns={@ORM\JoinColumn(name="userUuid", referencedColumnName="uuid")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="roleUuid", referencedColumnName="uuid")}
     * )
     * @var ArrayCollection $roles
     */
    protected $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="UserResetPassword",
     *     cascade={"persist", "remove"}, mappedBy="user", fetch="EXTRA_LAZY")
     * @var UserResetPassword[] $resetPassword
     */
    protected $resetPasswords;

    /**
     * User constructor.
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->roles = new ArrayCollection();
        $this->resetPasswords = new ArrayCollection();

        $this->renewHash();
    }

    /**
     * @return UserDetail|null
     */
    public function getDetail(): ?UserDetail
    {
        return $this->detail;
    }

    /**
     * @param UserDetail $detail
     * @return UserInterface
     */
    public function setDetail(UserDetail $detail): UserInterface
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * @return UserAvatar|null
     */
    public function getAvatar(): ?UserAvatar
    {
        return $this->avatar;
    }

    /**
     * @param UserAvatar $avatar
     * @return UserInterface
     */
    public function setAvatar(UserAvatar $avatar): UserInterface
    {
        $this->avatar = $avatar;

        $avatar->setUser($this);

        return $this;
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
     * @return UserInterface
     */
    public function setIdentity(string $identity): UserInterface
    {
        $this->identity = $identity;

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
     * @param string|null $password
     * @return UserInterface
     */
    public function setPassword(?string $password): UserInterface
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
     * @return UserInterface
     */
    public function setStatus(string $status): UserInterface
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function isDeleted(): string
    {
        return $this->isDeleted;
    }

    /**
     * @param string $isDeleted
     * @return $this
     */
    public function setIsDeleted(string $isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * @return string
     */
    public function getIsDeleted(): string
    {
        return $this->isDeleted;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     * @return $this
     */
    public function setHash(string $hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoles(): array
    {
        return $this->roles->toArray();
    }

    /**
     * @param UserRole $role
     * @return UserInterface
     */
    public function addRole(UserRole $role): UserInterface
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
        }

        return $this;
    }

    /**
     * @param UserRole $role
     * @return UserInterface
     */
    public function removeRole(UserRole $role): UserInterface
    {
        if (!$this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function renewHash()
    {
        $this->hash = self::generateHash();

        return $this;
    }

    /**
     * @return string
     * @throws Exception
     */
    public static function generateHash(): string
    {
        try {
            $bytes = random_bytes(32);
        } catch (Throwable $exception) {
            $bytes = UuidOrderedTimeGenerator::generateUuid()->getBytes();
        }

        return bin2hex($bytes);
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * @return $this
     */
    public function markAsDeleted(): self
    {
        $this->isDeleted = self::IS_DELETED_YES;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getDetail()->getFirstName() . ' ' . $this->getDetail()->getLastName();
    }

    /**
     * @return User
     */
    public function activate()
    {
        return $this->setStatus(self::STATUS_ACTIVE);
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function resetRoles(): self
    {
        foreach ($this->roles->getIterator()->getArrayCopy() as $role) {
            $this->removeRole($role);
        }
        $this->roles = new ArrayCollection();

        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function createResetPassword(): self
    {
        $resetPassword = new UserResetPassword();
        $resetPassword->setHash(self::generateHash());
        $resetPassword->setUser($this);

        $this->resetPasswords->add($resetPassword);

        return $this;
    }

    /**
     * @param UserResetPassword $resetPassword
     */
    public function addResetPassword(UserResetPassword $resetPassword)
    {
        $this->resetPasswords->add($resetPassword);
    }

    /**
     * @return ArrayCollection
     */
    public function getResetPasswords()
    {
        return $this->resetPasswords;
    }

    /**
     * @param UserResetPassword $resetPassword
     * @return bool
     */
    public function hasResetPassword(UserResetPassword $resetPassword): bool
    {
        return $this->resetPasswords->contains($resetPassword);
    }

    /**
     * @param UserResetPassword $resetPassword
     * @return $this
     */
    public function removeResetPassword(UserResetPassword $resetPassword): self
    {
        $this->resetPasswords->removeElement($resetPassword);

        return $this;
    }

    /**
     * @param array $resetPasswords
     * @return $this
     */
    public function setResetPasswords(array $resetPasswords): self
    {
        foreach ($resetPasswords as $resetPassword) {
            $this->resetPasswords->add($resetPassword);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getArrayCopy(): array
    {
        return [
            'uuid' => $this->getUuid()->toString(),
            'detail' => $this->getDetail() instanceof UserDetail ? $this->getDetail()->getArrayCopy() : null,
            'avatar' => $this->getAvatar() instanceof UserAvatar ? $this->getAvatar()->getArrayCopy() : null,
            'identity' => $this->getIdentity(),
            'status' => $this->getStatus(),
            'roles' => array_map(function (UserRole $role) {
                return $role->toArray();
            }, $this->getRoles()),
            'created' => $this->getCreated(),
            'updated' => $this->getUpdated()
        ];
    }
}
