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
use Packages\Infrastructure\EntityFactory\Comic\ComicEntityFactory;
use Tests\TestCase;
use TypeError;

class ComicTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var ComicEntityFactory
     */
    private $entityFactory;

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
        parent::setUp();
        $this->entityFactory = new ComicEntityFactory();
    }

    /**
     * @dataProvider provideCreateInstanceSuccess
     *
     * @param array $arguments
     *
     * @return void
     */
    public function testCreateInstanceSuccess(array $arguments): void
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
     * @dataProvider provideCreateInstanceFailure
     *
     * @param array $arguments
     *
     * @return void
     */
    public function testCreateInstanceFailure(array $arguments)
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
        $comic = $this->entityFactory->create(self::$defaultAttributes);
        $this->assertInstanceOf(ComicId::class, $comic->getId());
    }

    /**
     * @return void
     */
    public function testGetKey()
    {
        $comic = $this->entityFactory->create(self::$defaultAttributes);
        $this->assertInstanceOf(ComicKey::class, $comic->getKey());
    }

    /**
     * @return void
     */
    public function testGetName()
    {
        $comic = $this->entityFactory->create(self::$defaultAttributes);
        $this->assertInstanceOf(ComicName::class, $comic->getName());
    }

    /**
     * @return void
     */
    public function testGetStatus()
    {
        $comic = $this->entityFactory->create(self::$defaultAttributes);
        $this->assertInstanceOf(ComicStatus::class, $comic->getStatus());
    }

    /**
     * @return void
     */
    public function testGetCreatedAt()
    {
        $comic = $this->entityFactory->create(self::$defaultAttributes);
        $this->assertInstanceOf(Carbon::class, $comic->getCreatedAt());
    }

    /**
     * @return void
     */
    public function testGetUpdatedAt()
    {
        $comic = $this->entityFactory->create(self::$defaultAttributes);
        $this->assertInstanceOf(Carbon::class, $comic->getUpdatedAt());
    }

    /**
     * @dataProvider provideCanDelete
     *
     * @param array $attributes
     * @param bool $expected
     *
     * @return void
     */
    public function testCanDelete(array $attributes, bool $expected): void
    {
        $comic = $this->entityFactory->create($attributes);
        $this->assertSame($expected, $comic->canDelete());
    }

    /**
     * @return void
     */
    public function testToArray()
    {
        $comic = $this->entityFactory->create(self::$defaultAttributes);
        $this->assertSame(self::$defaultAttributes, $comic->toArray());
    }

    /**
     * @return array
     */
    public static function provideCreateInstanceSuccess(): array
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
    public static function provideCreateInstanceFailure(): array
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
     * @return array
     */
    public static function provideCanDelete(): array
    {
        return [
            [
                array_merge(self::$defaultAttributes, ['status' => 'published']),
                false,
            ],
            [
                array_merge(self::$defaultAttributes, ['status' => 'draft']),
                false,
            ],
            [
                array_merge(self::$defaultAttributes, ['status' => 'closed']),
                true,
            ],
        ];
    }
}
