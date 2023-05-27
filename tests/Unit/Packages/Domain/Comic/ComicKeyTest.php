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
     * @dataProvider provideCreateInstanceSucceeded
     *
     * @param string $key
     *
     * @return void
     */
    public function testCreateInstanceSucceeded(string $key)
    {
        $comicKey = new ComicKey($key);
        $this->assertInstanceOf(ComicKey::class, $comicKey);
    }

    /**
     * @dataProvider provideCreateInstanceFailed
     *
     * @param string $key
     *
     * @return void
     */
    public function testCreateInstanceFailed(string $key)
    {
        $this->expectException(InvalidArgumentException::class);
        new ComicKey($key);
    }

    /**
     * @return array
     */
    public function provideCreateInstanceSucceeded(): array
    {
        return [
            ['a'],
            ['-'],
            [$this->randomKey(255)],
        ];
    }

    /**
     * @return array
     */
    public function provideCreateInstanceFailed(): array
    {
        return [
            [''],
            ['_'],
            ['A'],
            ['あ'],
            [$this->randomKey(256)],
        ];
    }

    /**
     * @param int $length
     *
     * @return string
     */
    private function randomKey(int $length): string
    {
        $str = str_repeat('0123456789abcdefghijklmnopqrstuvwxyz-', $length);
        $str = str_shuffle($str);

        return substr($str, 0, $length);
    }
}
