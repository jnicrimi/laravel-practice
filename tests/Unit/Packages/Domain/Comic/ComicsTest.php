<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\Comics;
use Packages\Domain\Comic\ComicStatus;
use PHPUnit\Framework\TestCase;

class ComicsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testCreateInstance(): void
    {
        $comics = new Comics();
        $comics[] = new Comic(
            new ComicId(1),
            'key_1',
            'name_1',
            ComicStatus::PUBLISHED
        );
        $comics[] = new Comic(
            new ComicId(2),
            'key_2',
            'name_2',
            ComicStatus::PUBLISHED
        );
        $this->assertInstanceOf(Comics::class, $comics);
    }

    /**
     * @param array $attributes
     *
     * @return Comic
     */
    public function createEntity(array $attributes): Comic
    {
        return new Comic(
            new ComicId(Arr::get($attributes, 'id')),
            Arr::get($attributes, 'key'),
            Arr::get($attributes, 'name'),
            ComicStatus::PUBLISHED
        );
    }
}
