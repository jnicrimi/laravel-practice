<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicIdIsNotSetException;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\ComicStatus;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use TypeError;

class ComicTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var array
     */
    private static array $defaultAttributes = [
        'id' => 1,
        'key' => 'key',
        'name' => 'name',
        'status' => 'published',
        'created_at' => '2023-01-01 00:00:00',
        'updated_at' => '2023-12-31 23:59:59',
    ];

    #[DataProvider('provideCreateInstanceSuccess')]
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

    #[DataProvider('provideCreateInstanceFailure')]
    public function testCreateInstanceFailure(array $arguments): void
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

    public function testGetId(): void
    {
        $comic = $this->createEntity(self::$defaultAttributes);
        $this->assertInstanceOf(ComicId::class, $comic->getId());
    }

    public function testGetIdFailure(): void
    {
        $this->expectException(ComicIdIsNotSetException::class);
        $comic = $this->createEntity(array_merge(self::$defaultAttributes, ['id' => null]));
        $comic->getId();
    }

    public function testGetKey(): void
    {
        $comic = $this->createEntity(self::$defaultAttributes);
        $this->assertInstanceOf(ComicKey::class, $comic->getKey());
    }

    public function testGetName(): void
    {
        $comic = $this->createEntity(self::$defaultAttributes);
        $this->assertInstanceOf(ComicName::class, $comic->getName());
    }

    public function testGetStatus(): void
    {
        $comic = $this->createEntity(self::$defaultAttributes);
        $this->assertInstanceOf(ComicStatus::class, $comic->getStatus());
    }

    public function testGetCreatedAt(): void
    {
        $comic = $this->createEntity(self::$defaultAttributes);
        $this->assertInstanceOf(Carbon::class, $comic->getCreatedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $comic = $this->createEntity(self::$defaultAttributes);
        $this->assertInstanceOf(Carbon::class, $comic->getUpdatedAt());
    }

    public function testChangeKey(): void
    {
        $comic = $this->createEntity(self::$defaultAttributes);
        $newKey = 'new-key';
        $comic->changeKey(new ComicKey($newKey));
        $this->assertSame($newKey, $comic->getKey()->getValue());
    }

    public function testChangeName(): void
    {
        $comic = $this->createEntity(self::$defaultAttributes);
        $newName = 'new_name';
        $comic->changeName(new ComicName($newName));
        $this->assertSame($newName, $comic->getName()->getValue());
    }

    public function testChangeStatus(): void
    {
        $comic = $this->createEntity(self::$defaultAttributes);
        $newStatus = 'draft';
        $comic->changeStatus(ComicStatus::from($newStatus));
        $this->assertSame($newStatus, $comic->getStatus()->value);
    }

    #[DataProvider('provideCanDelete')]
    public function testCanDelete(array $attributes, bool $expected): void
    {
        $comic = $this->createEntity($attributes);
        $this->assertSame($expected, $comic->canDelete());
    }

    public function testToArray(): void
    {
        $comic = $this->createEntity(self::$defaultAttributes);
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
            Carbon::parse(Arr::get($attributes, 'created_at')),
            Carbon::parse(Arr::get($attributes, 'updated_at'))
        );
    }
}
