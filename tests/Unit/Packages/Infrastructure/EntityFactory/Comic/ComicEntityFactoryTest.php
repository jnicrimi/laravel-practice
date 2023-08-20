<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Infrastructure\EntityFactory\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Packages\Domain\Comic\Comic;
use Packages\Infrastructure\EntityFactory\Comic\ComicEntityFactory;
use Tests\TestCase;

class ComicEntityFactoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var ComicEntityFactory
     */
    private $entityFactory;

    /**
     * @var bool
     */
    protected $seed = true;

    /**
     * @var Comic
     */
    private $defaultEntity;

    /**
     * @var array
     */
    private $defaultAttributes = [
        'id' => 1,
        'key' => 'default',
        'name' => 'default',
        'status' => 'draft',
        'created_at' => '1900-01-01 00:00:00',
        'updated_at' => '1900-12-31 23:59:59',
    ];

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->entityFactory = $this->app->make(ComicEntityFactory::class);
        $this->defaultEntity = $this->entityFactory->create($this->defaultAttributes);
    }

    /**
     * @dataProvider provideCreateSuccess
     *
     * @param array $attributes
     * @param bool $hasEntity
     *
     * @return void
     */
    public function testCreateSuccess(array $attributes, bool $hasEntity): void
    {
        $entity = null;
        if ($hasEntity === true) {
            $entity = $this->defaultEntity;
        }
        $comic = $this->entityFactory->create($attributes, $entity);
        $this->assertInstanceOf(Comic::class, $comic);
        if ($entity !== null) {
            $this->assertTrue($entity->getId()->equals($comic->getId()));
        } else {
            $comicId = $comic->getId() ? $comic->getId()->getValue() : null;
            $this->assertSame($attributes['id'], $comicId);
        }
        $this->assertSame($attributes['key'], $comic->getKey()->getValue());
        $this->assertSame($attributes['name'], $comic->getName()->getValue());
        $this->assertSame($attributes['status'], $comic->getStatus()->value);
        $createdAt = $comic->getCreatedAt() ? $comic->getCreatedAt()->format(Comic::DATE_FORMAT) : null;
        $this->assertSame($attributes['created_at'], $createdAt);
        $updatedAt = $comic->getUpdatedAt() ? $comic->getUpdatedAt()->format(Comic::DATE_FORMAT) : null;
        $this->assertSame($attributes['updated_at'], $updatedAt);
    }

    /**
     * @dataProvider provideCreateFailure
     *
     * @param array $attributes
     * @param bool $hasEntity
     *
     * @return void
     */
    public function testCreateFailure(array $attributes, bool $hasEntity): void
    {
        $this->expectException(InvalidArgumentException::class);
        $entity = null;
        if ($hasEntity === true) {
            $entity = $this->defaultEntity;
        }
        $this->entityFactory->create($attributes, $entity);
    }

    /**
     * @return array
     */
    public static function provideCreateSuccess(): array
    {
        return [
            [
                [
                    'id' => PHP_INT_MAX,
                    'key' => 'key',
                    'name' => 'name',
                    'status' => 'published',
                    'created_at' => '2020-01-01 00:00:00',
                    'updated_at' => '2020-12-31 23:59:59',
                ],
                false,
            ],
            [
                [
                    'id' => null,
                    'key' => 'key',
                    'name' => 'name',
                    'status' => 'published',
                    'created_at' => null,
                    'updated_at' => null,
                ],
                false,
            ],
            [
                [
                    'key' => 'key',
                    'name' => 'name',
                    'status' => 'published',
                    'created_at' => null,
                    'updated_at' => null,
                ],
                true,
            ],
        ];
    }

    /**
     * @return array
     */
    public static function provideCreateFailure(): array
    {
        return [
            [
                [
                    'id' => 1,
                    'key' => 'key',
                    'name' => 'name',
                    'status' => 'published',
                    'created_at' => '2020-01-01 00:00:00',
                    'updated_at' => '2020-12-31 23:59:59',
                ],
                true,
            ],
        ];
    }
}
