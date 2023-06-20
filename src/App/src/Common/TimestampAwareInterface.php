<?php

declare(strict_types=1);

namespace Frontend\App\Common;

use DateTimeImmutable;

/**
 * Interface TimestampAwareInterface
 */
interface TimestampAwareInterface
{
    public function getCreated(): DateTimeImmutable;

    public function getCreatedFormatted(?string $dateFormat = null): string;

    public function getUpdated(): ?DateTimeImmutable;

    public function getUpdatedFormatted(?string $dateFormat = null): ?string;

    public function setDateFormat(string $dateFormat): void;

    /**
     * Update internal timestamps
     */
    public function touch(): void;
}
