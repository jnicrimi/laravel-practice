<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Packages\Domain\Comic\Comics;
use Packages\Infrastructure\EntityFactory\Comic\ComicEntityFactory;
use Tests\TestCase;
use TypeError;

class ComicsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var ComicEntityFactory
     */
    private $entityFactory;

    /**
     * @var array
     */
    private $defaultAttributes = [
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
     * @return void
     */
    public function testCreateInstanceSuccess(): void
    {
        $comics = new Comics();
        $comics[] = $this->entityFactory->create($this->defaultAttributes);
        $comics[] = $this->entityFactory->create(array_merge($this->defaultAttributes, ['id' => 2]));
        $this->assertInstanceOf(Comics::class, $comics);
    }

    /**
     * @return void
     */
    public function testCreateInstanceFailure(): void
    {
        $this->expectException(TypeError::class);
        $comics = new Comics();
        $comics[] = $this->entityFactory->create($this->defaultAttributes);
        $comics[] = null;
    }
}
