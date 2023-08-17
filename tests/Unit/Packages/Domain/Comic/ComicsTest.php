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
use Packages\Domain\Comic\Comics;
use Packages\Domain\Comic\ComicStatus;
use Tests\TestCase;
use TypeError;

class ComicsTest extends TestCase
{
    use RefreshDatabase;

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
    public function testCreateInstanceSucceed(): void
    {
        $comics = new Comics();
        $comics[] = $this->createEntity($this->defaultAttributes);
        $comics[] = $this->createEntity(array_merge($this->defaultAttributes, ['id' => 2]));
        $this->assertInstanceOf(Comics::class, $comics);
    }

    /**
     * @return void
     */
    public function testCreateInstanceFailed(): void
    {
        $this->expectException(TypeError::class);
        $comics = new Comics();
        $comics[] = $this->createEntity($this->defaultAttributes);
        $comics[] = null;
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
