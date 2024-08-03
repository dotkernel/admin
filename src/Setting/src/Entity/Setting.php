<?php

declare(strict_types=1);

namespace Admin\Setting\Entity;

use Admin\Admin\Entity\Admin;
use Admin\App\Entity\AbstractEntity;
use Admin\App\Entity\TimestampsTrait;
use Admin\Setting\Repository\SettingRepository;
use Doctrine\ORM\Mapping as ORM;

use function array_unique;
use function json_decode;
use function json_encode;

#[ORM\Entity(repositoryClass: SettingRepository::class)]
#[ORM\Table(name: 'settings')]
#[ORM\HasLifecycleCallbacks]
class Setting extends AbstractEntity
{
    use TimestampsTrait;

    public const IDENTIFIER_TABLE_ADMIN_LIST_SELECTED_COLUMNS        = 'table_admin_list_selected_columns';
    public const IDENTIFIER_TABLE_ADMIN_LIST_LOGINS_SELECTED_COLUMNS = 'table_admin_list_logins_selected_columns';
    public const IDENTIFIERS                                         = [
        self::IDENTIFIER_TABLE_ADMIN_LIST_SELECTED_COLUMNS,
        self::IDENTIFIER_TABLE_ADMIN_LIST_LOGINS_SELECTED_COLUMNS,
    ];

    #[ORM\ManyToOne(targetEntity: Admin::class, inversedBy: 'settings')]
    #[ORM\JoinColumn(name: 'admin_uuid', referencedColumnName: 'uuid')]
    protected Admin $admin;

    #[ORM\Column(name: "identifier", type: "string", length: 50)]
    protected string $identifier;

    #[ORM\Column(name: "value", type: "text")]
    protected string $value;

    public function __construct(Admin $admin, string $identifier, array $value)
    {
        parent::__construct();

        $this->setAdmin($admin);
        $this->setIdentifier($identifier);
        $this->setValue($value);
    }

    public function getAdmin(): Admin
    {
        return $this->admin;
    }

    public function setAdmin(Admin $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getValue(): mixed
    {
        return json_decode($this->value, true);
    }

    public function setValue(array $value): self
    {
        $this->value = json_encode(array_unique($value));

        return $this;
    }

    public function getArrayCopy(): array
    {
        return [
            'uuid'       => $this->getUuid()->toString(),
            'identifier' => $this->getIdentifier(),
            'value'      => $this->getValue(),
        ];
    }
}
