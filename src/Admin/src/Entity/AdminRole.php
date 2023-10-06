<?php

declare(strict_types=1);

namespace Frontend\Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Frontend\App\Entity\AbstractEntity;

/**
 * @ORM\Entity(repositoryClass="Frontend\Admin\Repository\AdminRoleRepository")
 * @ORM\Table(name="admin_role")
 * @ORM\HasLifecycleCallbacks()
 */
class AdminRole extends AbstractEntity
{
    public const ROLE_ADMIN     = 'admin';
    public const ROLE_SUPERUSER = 'superuser';
    public const ROLES          = [
        self::ROLE_ADMIN,
        self::ROLE_SUPERUSER,
    ];

    /** @ORM\Column(name="name", type="string", length=30, nullable=false, unique=true) */
    protected ?string $name = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getArrayCopy(): array
    {
        return [
            'uuid'    => $this->getUuid()->toString(),
            'name'    => $this->getName(),
            'created' => $this->getCreated(),
            'updated' => $this->getUpdated(),
        ];
    }
}
