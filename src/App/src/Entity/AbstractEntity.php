<?php

namespace Frontend\App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Exception;
use Frontend\App\Common\UuidOrderedTimeGenerator;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Base
 * @package Frontend\App\Entity
 */
abstract class AbstractEntity
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="uuid", type="uuid_binary_ordered_time", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidOrderedTimeGenerator")
     * @var UuidInterface
     */
    protected $uuid;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime
     */
    protected $updated;

    /**
     * AbstractEntity constructor.
     */
    public function __construct()
    {
        $this->uuid = UuidOrderedTimeGenerator::generateUuid();
        $this->created = new DateTime('now');
        $this->updated = new DateTime('now');
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateTimestamps()
    {
        $this->touch();
    }

    /**
     * @return void
     */
    public function touch(): void
    {
        try {
            if (!($this->created instanceof DateTime)) {
                $this->created = new DateTime('now');
            }

            $this->updated = new DateTime('now');
        } catch (Exception $exception) {
            #TODO save the error message
        }
    }
}
