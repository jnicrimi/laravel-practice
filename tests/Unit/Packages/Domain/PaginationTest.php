<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Packages\Domain\Pagination;
use Tests\TestCase;

class PaginationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testGetPerPage(): void
    {
        $pagination = $this->createPagination();
        $actual = $pagination->getPerPage();
        $this->assertSame(5, $actual);
    }

    /**
     * @return void
     */
    public function testGetCurrentPage(): void
    {
        $pagination = $this->createPagination();
        $actual = $pagination->getCurrentPage();
        $this->assertSame(1, $actual);
    }

    /**
     * @return void
     */
    public function testGetLastPage(): void
    {
        $pagination = $this->createPagination();
        $actual = $pagination->getLastPage();
        $this->assertSame(2, $actual);
    }

    /**
     * @return void
     */
    public function testGetTotal(): void
    {
        $pagination = $this->createPagination();
        $actual = $pagination->getTotal();
        $this->assertSame(10, $actual);
    }

    /**
     * @return void
     */
    public function testGetFirstItem(): void
    {
        $pagination = $this->createPagination();
        $actual = $pagination->getFirstItem();
        $this->assertSame(1, $actual);
    }

    /**
     * @return void
     */
    public function testGetLastItem(): void
    {
        $pagination = $this->createPagination();
        $actual = $pagination->getLastItem();
        $this->assertSame(5, $actual);
    }

    /**
     * @return Pagination
     */
    private function createPagination(): Pagination
    {
        $perPage = 5;
        $currentPage = 1;
        $lastPage = 2;
        $total = 10;
        $firstItem = 1;
        $lastItem = 5;

        return new Pagination(
            $perPage,
            $currentPage,
            $lastPage,
            $total,
            $firstItem,
            $lastItem
        );
    }
}
