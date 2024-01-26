<?php

declare(strict_types=1);

namespace Packages\Domain;

class Pagination
{
    /**
     * Constructor
     *
     * @param int $perPage
     * @param int $currentPage
     * @param int $lastPage
     * @param int $total
     * @param int $firstItem
     * @param int $lastItem
     */
    public function __construct(
        private int $perPage,
        private int $currentPage,
        private int $lastPage,
        private int $total,
        private int $firstItem,
        private int $lastItem
    ) {
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getFirstItem(): int
    {
        return $this->firstItem;
    }

    /**
     * @return int
     */
    public function getLastItem(): int
    {
        return $this->lastItem;
    }
}
