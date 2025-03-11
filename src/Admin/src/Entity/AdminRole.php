<?php

declare(strict_types=1);

namespace Admin\Admin\Entity;

use Admin\Admin\Enum\AdminRoleEnum;
use Admin\Admin\Repository\AdminRoleRepository;
use Admin\App\Entity\AbstractEntity;
use Admin\App\Entity\TimestampsTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminRoleRepository::class)]
#[ORM\Table(name: 'admin_role')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Cache(usage: "NONSTRICT_READ_WRITE")]
class AdminRole extends AbstractEntity
{
    use TimestampsTrait;

    #[ORM\Column(
        type: 'admin_role_enum',
        nullable: true,
        enumType: AdminRoleEnum::class,
        options: ['default' => AdminRoleEnum::Admin]
    )
    ]
    protected AdminRoleEnum $name = AdminRoleEnum::Admin;

    public function getName(): AdminRoleEnum
    {
        return $this->name;
    }

    public function setName(AdminRoleEnum $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getArrayCopy(): array
    {
        return [
            'uuid'    => $this->getUuid()->toString(),
            'name'    => $this->getName()->value,
            'created' => $this->getCreated(),
            'updated' => $this->getUpdated(),
        ];
    }
}
