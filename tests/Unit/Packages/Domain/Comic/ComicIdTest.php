<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Packages\Domain\Comic\ComicId;
use Tests\TestCase;

class ComicIdTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider provideCreateInstanceSucceeded
     *
     * @param int $id
     *
     * @return void
     */
    public function testCreateInstanceSucceeded(int $id)
    {
        $comicId = new ComicId($id);
        $this->assertInstanceOf(ComicId::class, $comicId);
    }

    /**
     * @dataProvider provideCreateInstanceFailed
     *
     * @param mixed $id
     *
     * @return void
     */
    public function testCreateInstanceFailed($id)
    {
        $this->expectException(InvalidArgumentException::class);
        new ComicId($id);
    }

    /**
     * @return array
     */
    public static function provideCreateInstanceSucceeded(): array
    {
        return [
            [1],
            [PHP_INT_MAX],
        ];
    }

    /**
     * @return array
     */
    public static function provideCreateInstanceFailed(): array
    {
        return [
            [0],
            [-1],
            ['1'],
            ['a'],
            [null],
        ];
    }
}
