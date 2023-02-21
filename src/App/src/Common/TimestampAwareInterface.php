<?php

declare(strict_types=1);

namespace Frontend\App\Common;

use DateTimeImmutable;

/**
 * Interface TimestampAwareInterface
 * @package Frontend\App\Common
 */
interface TimestampAwareInterface
{
    /**
     * @return DateTimeImmutable
     */
    public function getCreated(): DateTimeImmutable;

    /**
     * @param string|null $dateFormat
     * @return string
     */
    public function getCreatedFormatted(?string $dateFormat = null): string;

    /**
     * @return DateTimeImmutable|null
     */
    public function getUpdated(): ?DateTimeImmutable;

    /**
     * @param string|null $dateFormat
     * @return string|null
     */
    public function getUpdatedFormatted(?string $dateFormat = null): ?string;

    /**
     * @param string $dateFormat
     * @return void
     */
    public function setDateFormat(string $dateFormat): void;

    /**
     * Update internal timestamps
     */
    public function touch(): void;
}
