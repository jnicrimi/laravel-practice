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
     * @dataProvider provideCreateInstanceSuccess
     *
     * @param int $id
     *
     * @return void
     */
    public function testCreateInstanceSuccess(int $id)
    {
        $comicId = new ComicId($id);
        $this->assertInstanceOf(ComicId::class, $comicId);
    }

    /**
     * @dataProvider provideCreateInstanceFailure
     *
     * @param mixed $id
     *
     * @return void
     */
    public function testCreateInstanceFailure($id)
    {
        $this->expectException(InvalidArgumentException::class);
        new ComicId($id);
    }

    /**
     * @return array
     */
    public static function provideCreateInstanceSuccess(): array
    {
        return [
            [1],
            [PHP_INT_MAX],
        ];
    }

    /**
     * @return array
     */
    public static function provideCreateInstanceFailure(): array
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
