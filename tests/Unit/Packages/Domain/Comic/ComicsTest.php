<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\Comics;
use Packages\Domain\Comic\ComicStatus;
use Tests\TestCase;

class ComicsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var array
     */
    private $defaultAttributes = [
        'key-1' => [
            'id' => 1,
            'key' => 'key-1',
            'name' => 'name-1',
            'status' => 'published',
        ],
        'key-2' => [
            'id' => 2,
            'key' => 'key-2',
            'name' => 'name-2',
            'status' => 'closed',
        ],
    ];

    /**
     * @return void
     */
    public function testCreateInstance(): void
    {
        $comics = new Comics();
        $comics[] = $this->createEntity($this->defaultAttributes['key-1']);
        $comics[] = $this->createEntity($this->defaultAttributes['key-2']);
        $this->assertInstanceOf(Comics::class, $comics);
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
