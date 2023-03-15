<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicStatus;
use Packages\Domain\Comic\ComicStatusCase;
use PHPUnit\Framework\TestCase;

class ComicTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Comic
     */
    private $comic;

    /**
     * @var int
     */
    private $id = 1;

    /**
     * @var string
     */
    private $key = 'key';

    /**
     * @var string
     */
    private $name = 'name';

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->comic = new Comic(
            new ComicId($this->id),
            $this->key,
            $this->name,
            new ComicStatus(ComicStatusCase::PUBLISH)
        );
    }

    /**
     * @return void
     */
    public function testGetId()
    {
        $this->assertInstanceOf(ComicId::class, $this->comic->getId());
    }

    /**
     * @return void
     */
    public function testGetKey()
    {
        $this->assertSame($this->key, $this->comic->getKey());
    }

    /**
     * @return void
     */
    public function testGetName()
    {
        $this->assertSame($this->name, $this->comic->getName());
    }

    /**
     * @return void
     */
    public function testGetStatus()
    {
        $this->assertInstanceOf(ComicStatus::class, $this->comic->getStatus());
    }
}