<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\ComicStatus;
use Tests\TestCase;
use TypeError;

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
    private static $defaultAttributes = [
        'id' => 1,
        'key' => 'key',
        'name' => 'name',
        'status' => 'published',
        'created_at' => '2023-01-01 00:00:00',
        'updated_at' => '2023-12-31 23:59:59',
    ];

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->comic = $this->createEntity(self::$defaultAttributes);
    }

    /**
     * @dataProvider provideCreateInstanceSucceeded
     *
     * @param array $arguments
     *
     * @return void
     */
    public function testCreateInstanceSucceeded(array $arguments): void
    {
        $comic = new Comic(
            Arr::get($arguments, 'id'),
            Arr::get($arguments, 'key'),
            Arr::get($arguments, 'name'),
            Arr::get($arguments, 'status'),
            Arr::get($arguments, 'created_at'),
            Arr::get($arguments, 'updated_at')
        );
        $this->assertInstanceOf(Comic::class, $comic);
    }

    /**
     * @dataProvider provideCreateInstanceFailed
     *
     * @param array $arguments
     *
     * @return void
     */
    public function testCreateInstanceFailed(array $arguments)
    {
        $this->expectException(TypeError::class);
        new Comic(
            Arr::get($arguments, 'id'),
            Arr::get($arguments, 'key'),
            Arr::get($arguments, 'name'),
            Arr::get($arguments, 'status'),
            Arr::get($arguments, 'created_at'),
            Arr::get($arguments, 'updated_at')
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
    public function testGetCreatedAt()
    {
        $createdAt = $this->comic->getCreatedAt();
        $this->assertInstanceOf(Carbon::class, $createdAt);
    }

    /**
     * @return void
     */
    public function testGetUpdatedAt()
    {
        $updatedAt = $this->comic->getUpdatedAt();
        $this->assertInstanceOf(Carbon::class, $updatedAt);
    }

    /**
     * @return void
     */
    public function testToArray()
    {
        $this->assertSame(
            array_keys(self::$defaultAttributes),
            array_keys($this->comic->toArray())
        );
    }

    /**
     * @return array
     */
    public static function provideCreateInstanceSucceeded(): array
    {
        $default = [
            'id' => new ComicId(Arr::get(self::$defaultAttributes, 'id')),
            'name' => new ComicName(Arr::get(self::$defaultAttributes, 'name')),
            'key' => new ComicKey(Arr::get(self::$defaultAttributes, 'key')),
            'status' => ComicStatus::from(Arr::get(self::$defaultAttributes, 'status')),
            'created_at' => Carbon::parse(Arr::get(self::$defaultAttributes, 'created_at')),
            'updated_at' => Carbon::parse(Arr::get(self::$defaultAttributes, 'updated_at')),
        ];

        return [
            [$default],
            [array_merge($default, ['id' => null])],
            [array_merge($default, ['created_at' => null])],
            [array_merge($default, ['updated_at' => null])],
        ];
    }

    /**
     * @return array
     */
    public static function provideCreateInstanceFailed(): array
    {
        $default = [
            'id' => new ComicId(Arr::get(self::$defaultAttributes, 'id')),
            'name' => new ComicName(Arr::get(self::$defaultAttributes, 'name')),
            'key' => new ComicKey(Arr::get(self::$defaultAttributes, 'key')),
            'status' => ComicStatus::from(Arr::get(self::$defaultAttributes, 'status')),
            'created_at' => Carbon::parse(Arr::get(self::$defaultAttributes, 'created_at')),
            'updated_at' => Carbon::parse(Arr::get(self::$defaultAttributes, 'updated_at')),
        ];

        return [
            [array_merge($default, ['name' => null])],
            [array_merge($default, ['key' => null])],
            [array_merge($default, ['status' => null])],
        ];
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
            ComicStatus::from(Arr::get($attributes, 'status')),
            Arr::get($attributes, 'created_at') ? Carbon::parse(Arr::get($attributes, 'created_at')) : null,
            Arr::get($attributes, 'updated_at') ? Carbon::parse(Arr::get($attributes, 'updated_at')) : null
        );
    }
}
