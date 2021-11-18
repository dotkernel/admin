<?php

declare(strict_types=1);

namespace Frontend\App\Common;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait TimestampAwareTrait
 * @package Frontend\App\Common
 */
trait TimestampAwareTrait
{
    private string $dateFormat = 'Y-m-d H:i:s';

    /**
     * @ORM\Column(name="created", type="datetime_immutable")
     * @var DateTimeImmutable|null
     */
    protected ?DateTimeImmutable $created = null;

    /**
     * @ORM\Column(name="updated", type="datetime_immutable", nullable=true)
     * @var DateTimeImmutable|null
     */
    protected ?DateTimeImmutable $updated = null;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * @return void
     */
    public function updateTimestamps(): void
    {
        $this->touch();
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getCreated(): ?DateTimeImmutable
    {
        return $this->created;
    }

    /**
     * @return null|string
     */
    public function getCreatedFormatted(): ?string
    {
        if ($this->created instanceof DateTimeImmutable) {
            return $this->created->format($this->dateFormat);
        }

        return null;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getUpdated(): ?DateTimeImmutable
    {
        return $this->updated;
    }

    /**
     * @return null|string
     */
    public function getUpdatedFormatted(): ?string
    {
        if ($this->updated instanceof DateTimeImmutable) {
            return $this->updated->format($this->dateFormat);
        }

        return null;
    }

    /**
     * @param string $dateFormat
     * @return void
     */
    public function setDateFormat(string $dateFormat): void
    {
        $this->dateFormat = $dateFormat;
    }

    /**
     * @return $this
     */
    public function touch(): self
    {
        if (!($this->created instanceof DateTimeImmutable)) {
            $this->created = new DateTimeImmutable();
        }

        $this->updated = new DateTimeImmutable();

        return $this;
    }
}
