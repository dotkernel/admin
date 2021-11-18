<?php

declare(strict_types=1);

namespace Frontend\User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Frontend\App\Entity\AbstractEntity;

/**
 * Class UserDetail
 * @ORM\Entity(repositoryClass="Frontend\User\Repository\UserDetailRepository")
 * @ORM\Table(name="user_detail")
 * @ORM\HasLifecycleCallbacks()
 * @package Frontend\User\Entity
 */
class UserDetail extends AbstractEntity
{
    /**
     * @ORM\OneToOne(targetEntity="Frontend\User\Entity\User", inversedBy="detail")
     * @ORM\JoinColumn(name="userUuid", referencedColumnName="uuid", nullable=false)
     * @var UserInterface $user
     */
    protected $user;

    /**
     * @ORM\Column(name="firstName", type="string", length=191, nullable=true)
     * @var $firstName
     */
    protected $firstName;

    /**
     * @ORM\Column(name="lastName", type="string", length=191, nullable=true)
     * @var $lastName
     */
    protected $lastName;

    /**
     * UserDetail constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param $firstName
     * @return $this
     */
    public function setFirstName($firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param $lastName
     * @return $this
     */
    public function setLastName($lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return array
     */
    public function getArrayCopy(): array
    {
        return [
            'uuid' => $this->getUuid()->toString(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'created' => $this->getCreated(),
            'updated' => $this->getUpdated()
        ];
    }
}
