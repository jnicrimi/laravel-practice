<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
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
     * @var array
     */
    private $defaultAttributes = [
        'id' => 1,
        'key' => 'key',
        'name' => 'name',
        'status' => 'published',
    ];

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->comic = $this->createEntity($this->defaultAttributes);
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
        $this->assertInstanceOf(ComicKey::class, $this->comic->getKey());
    }

    /**
     * @return void
     */
    public function testGetName()
    {
        $this->assertInstanceOf(ComicName::class, $this->comic->getName());
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
            'id' => Arr::get($this->defaultAttributes, 'id'),
            'key' => Arr::get($this->defaultAttributes, 'key'),
            'name' => Arr::get($this->defaultAttributes, 'name'),
            'status' => ComicStatus::from(Arr::get($this->defaultAttributes, 'status'))->value,
        ], $this->comic->toArray());
    }

    /**
     * @param array $attributes
     *
     * @return Comic
     */
    private function createEntity(array $attributes): Comic
    {
        return new Comic(
            Arr::get($attributes, 'id') ? new ComicId(Arr::get($attributes, 'id')) : null,
            new ComicKey(Arr::get($attributes, 'key')),
            new ComicName(Arr::get($attributes, 'name')),
            ComicStatus::from(Arr::get($attributes, 'status'))
        );
    }
}
