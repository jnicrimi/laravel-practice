<?php

declare(strict_types=1);

namespace Packages\Domain;

class Pagination
{
    /**
     * @var int
     */
    private $perPage;

    /**
     * @var int
     */
    private $currentPage;

    /**
     * @var int
     */
    private $lastPage;

    /**
     * @var int
     */
    private $total;

    /**
     * @var int
     */
    private $firstItem;

    /**
     * @var int
     */
    private $lastItem;

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
        int $perPage,
        int $currentPage,
        int $lastPage,
        int $total,
        int $firstItem,
        int $lastItem
    ) {
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
        $this->lastPage = $lastPage;
        $this->total = $total;
        $this->firstItem = $firstItem;
        $this->lastItem = $lastItem;
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
