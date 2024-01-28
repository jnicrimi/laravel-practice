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
        public readonly int $perPage,
        public readonly int $currentPage,
        public readonly int $lastPage,
        public readonly int $total,
        public readonly int $firstItem,
        public readonly int $lastItem
    ) {
    }
}
