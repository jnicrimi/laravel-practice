<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Packages\Domain\Comic\ComicKey;
use Tests\TestCase;

class ComicKeyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider provideCreateInstanceSuccess
     *
     * @param string $key
     *
     * @return void
     */
    public function testCreateInstanceSuccess(string $key)
    {
        $comicKey = new ComicKey($key);
        $this->assertInstanceOf(ComicKey::class, $comicKey);
    }

    /**
     * @dataProvider provideCreateInstanceFailure
     *
     * @param mixed $key
     *
     * @return void
     */
    public function testCreateInstanceFailure($key)
    {
        $this->expectException(InvalidArgumentException::class);
        new ComicKey($key);
    }

    /**
     * @return array
     */
    public static function provideCreateInstanceSuccess(): array
    {
        return [
            ['a'],
            ['-'],
            [self::randomKey(255)],
        ];
    }

    /**
     * @return array
     */
    public static function provideCreateInstanceFailure(): array
    {
        return [
            [''],
            ['_'],
            ['A'],
            ['あ'],
            [self::randomKey(256)],
            [0],
            [1],
            [null],
        ];
    }

    /**
     * @param int $length
     *
     * @return string
     */
    private static function randomKey(int $length): string
    {
        $str = str_repeat('0123456789abcdefghijklmnopqrstuvwxyz-', $length);
        $str = str_shuffle($str);

        return substr($str, 0, $length);
    }
}
