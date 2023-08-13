<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain;

use ArrayIterator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Packages\Domain\AbstractEntities;
use Packages\Domain\Pagination;
use Tests\TestCase;

class AbstractEntitiesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider provideOffsetExists
     *
     * @param mixed $expected
     * @param mixed $offset
     *
     * @return void
     */
    public function testOffsetExists($expected, $offset)
    {
        $entities = $this->createEntities();
        $actual = $entities->offsetExists($offset);
        $this->assertSame($expected, $actual);
    }

    /**
     * @dataProvider provideOffsetGet
     *
     * @param mixed $expected
     * @param mixed $offset
     *
     * @return void
     */
    public function testOffsetGet($expected, $offset)
    {
        $entities = $this->createEntities();
        $actual = $entities->offsetGet($offset);
        $this->assertSame($expected, $actual);
    }

    /**
     * @dataProvider provideOffsetSet
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     */
    public function testOffsetSet($offset, $value)
    {
        $this->expectException(InvalidArgumentException::class);
        $entities = $this->createEntities();
        $entities->offsetSet($offset, $value);
    }

    /**
     * @dataProvider provideOffsetUnset
     *
     * @param mixed $expected
     * @param mixed $offset
     *
     * @return void
     */
    public function testOffsetUnset($expected, $offset)
    {
        $entities = $this->createEntities();
        $entities->offsetUnset($offset);
        $actual = $entities->count();
        $this->assertSame($actual, $expected);
    }

    /**
     * @return void
     */
    public function testCount()
    {
        $entities = $this->createEntities();
        $actual = $entities->count();
        $expected = 3;
        $this->assertSame($actual, $expected);
    }

    /**
     * @doesNotPerformAssertions
     *
     * @return void
     */
    public function testSetPagination()
    {
        $pagination = $this->createPagination();
        $entities = $this->createEntities();
        $entities->setPagination($pagination);
    }

    /**
     * @return void
     */
    public function testGetPagination()
    {
        $pagination = $this->createPagination();
        $entities = $this->createEntities();
        $entities->setPagination($pagination);
        $pagination = $entities->getPagination();
        $this->assertInstanceOf(Pagination::class, $pagination);
    }

    /**
     * @return void
     */
    public function testGetIterator()
    {
        $entities = $this->createEntities();
        $iterator = $entities->getIterator();
        $this->assertInstanceOf(ArrayIterator::class, $iterator);
    }

    /**
     * @return array
     */
    public static function provideOffsetExists(): array
    {
        return [
            [true, 'a'],
            [true, 'b'],
            [true, 'c'],
            [false, 'd'],
        ];
    }

    /**
     * @return array
     */
    public static function provideOffsetGet(): array
    {
        return [
            ['A', 'a'],
            ['B', 'b'],
            ['C', 'c'],
            [null, 'd'],
        ];
    }

    /**
     * @return array
     */
    public static function provideOffsetSet(): array
    {
        return [
            ['d', new class () {}],
        ];
    }

    /**
     * @return array
     */
    public static function provideOffsetUnset(): array
    {
        return [
            [2, 'a'],
            [2, 'b'],
            [2, 'c'],
            [3, 'd'],
        ];
    }

    /**
     * @return AbstractEntities
     */
    private function createEntities(): AbstractEntities
    {
        return new class () extends AbstractEntities {
            protected $entities = [
                'a' => 'A',
                'b' => 'B',
                'c' => 'C',
            ];

            protected function getEntityClass(): string
            {
                return 'entities';
            }
        };
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
