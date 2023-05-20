<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\Comics;
use Packages\Domain\Comic\ComicStatus;
use Tests\TestCase;

class ComicsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testCreateInstance(): void
    {
        $comics = new Comics();
        $comics[] = $this->createEntity([
            'id' => 1,
            'key' => 'key_1',
            'name' => 'name_1',
            'status' => ComicStatus::PUBLISHED->value,
        ]);
        $comics[] = $this->createEntity([
            'id' => 2,
            'key' => 'key_2',
            'name' => 'name_2',
            'status' => ComicStatus::CLOSED->value,
        ]);
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
            Arr::get($attributes, 'key'),
            Arr::get($attributes, 'name'),
            ComicStatus::from(Arr::get($attributes, 'status'))
        );
    }
}
