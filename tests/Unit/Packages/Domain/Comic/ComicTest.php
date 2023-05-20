<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicStatus;
use Tests\TestCase;

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
            ComicStatus::PUBLISHED
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

    /**
     * @return void
     */
    public function testToArray()
    {
        $this->assertSame([
            'id' => $this->id,
            'key' => $this->key,
            'name' => $this->name,
            'status' => ComicStatus::PUBLISHED->value,
        ], $this->comic->toArray());
    }
}
