<?php

declare(strict_types=1);

namespace Admin\App;

use function ceil;
use function max;
use function min;
use function range;

readonly class Pagination
{
    private int $firstPage;
    private int $currentPage;
    private int $lastPage;
    private int $range;

    public function __construct(
        private int $total,
        private int $offset = 0,
        private int $limit,
    ) {
        $this->range       = 5;
        $this->firstPage   = 1;
        $this->currentPage = (int) ceil($this->offset / $this->limit) + 1;
        $this->lastPage    = $this->total > 0 ? (int) ceil($this->total / $this->limit) : $this->firstPage;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function isFirstPage(): bool
    {
        return $this->currentPage === $this->firstPage;
    }

    public function getFirstPage(): int
    {
        return $this->firstPage;
    }

    public function hasPreviousPage(): bool
    {
        return $this->currentPage > $this->firstPage;
    }

    public function getPreviousPage(): int
    {
        return max($this->currentPage - 1, 1);
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function hasNextPage(): bool
    {
        return $this->currentPage < $this->lastPage;
    }

    public function getNextPage(): int
    {
        return min($this->currentPage + 1, $this->lastPage);
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    public function isLastPage(): bool
    {
        return $this->currentPage === $this->lastPage;
    }

    public function isOutOfBounds(): bool
    {
        return $this->currentPage > $this->lastPage;
    }

    public function getFirstOffset(): int
    {
        return 0;
    }

    public function getPreviousOffset(): int
    {
        return max(0, $this->offset - $this->limit);
    }

    public function getNextOffset(): int
    {
        return min($this->offset + $this->limit, $this->getLastOffset());
    }

    public function getLastOffset(): int
    {
        return ($this->lastPage - 1) * $this->limit;
    }

    public function getPages(): array
    {
        return range(
            max(1, $this->currentPage - $this->range),
            min($this->lastPage, $this->currentPage + $this->range)
        );
    }
}
