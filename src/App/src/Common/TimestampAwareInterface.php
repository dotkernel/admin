<?php

declare(strict_types=1);

namespace Frontend\App\Common;

use DateTimeImmutable;

interface TimestampAwareInterface
{
    public function getCreated(): ?DateTimeImmutable;

    public function getCreatedFormatted(?string $dateFormat = null): string;

    public function getUpdated(): ?DateTimeImmutable;

    public function getUpdatedFormatted(?string $dateFormat = null): ?string;

    public function setDateFormat(string $dateFormat): void;

    public function touch(): void;
}
