<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Packages\Domain\Comic\ComicName;
use Tests\TestCase;

class ComicNameTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider provideCreateInstanceSuccess
     *
     * @param string $name
     *
     * @return void
     */
    public function testCreateInstanceSuccess(string $name)
    {
        $comicName = new ComicName($name);
        $this->assertInstanceOf(ComicName::class, $comicName);
    }

    /**
     * @dataProvider provideCreateInstanceFailure
     *
     * @param mixed $name
     *
     * @return void
     */
    public function testCreateInstanceFailure($name)
    {
        $this->expectException(InvalidArgumentException::class);
        new ComicName($name);
    }

    /**
     * @return array
     */
    public static function provideCreateInstanceSuccess(): array
    {
        return [
            ['a'],
            [str_repeat('a', 255)],
        ];
    }

    /**
     * @return array
     */
    public static function provideCreateInstanceFailure(): array
    {
        return [
            [''],
            [str_repeat('a', 256)],
            [0],
            [1],
            [null],
        ];
    }
}
