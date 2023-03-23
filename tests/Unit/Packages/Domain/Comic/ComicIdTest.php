<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Packages\Domain\Comic\ComicId;
use PHPUnit\Framework\TestCase;

class ComicIdTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testCreateInstanceSucceeded()
    {
        $comicId = new ComicId(1);
        $this->assertInstanceOf(ComicId::class, $comicId);
    }

    /**
     * @return void
     */
    public function testCreateInstanceFailed()
    {
        $this->expectException(InvalidArgumentException::class);
        $comicId = new ComicId(-1);
    }
}