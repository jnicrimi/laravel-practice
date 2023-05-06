<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Infrastructure\Comic;

use App\Models\Comic as ComicModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\Comics;
use Packages\Domain\Comic\ComicStatus;
use Packages\Infrastructure\Comic\ComicRepository;
use Tests\TestCase;

class ComicRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var ComicRepository
     */
    private $repository;

    /**
     * @var bool
     */
    protected $seed = true;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(ComicRepository::class);
    }

    /**
     * @return void
     */
    public function testFindSucceeded(): void
    {
        $comicId = new ComicId(1);
        $comic = $this->repository->find($comicId);
        $this->assertInstanceOf(Comic::class, $comic);
    }

    /**
     * @return void
     */
    public function testFindFailed(): void
    {
        $comicId = new ComicId(0);
        $comic = $this->repository->find($comicId);
        $this->assertNull($comic);
    }

    /**
     * @return void
     */
    public function testAll(): void
    {
        $comics = $this->repository->all();
        $this->assertInstanceOf(Comics::class, $comics);
    }

    /**
     * @doesNotPerformAssertions
     *
     * @return void
     */
    public function testSave(): void
    {
        $comic = $this->createEntity([
            'key' => 'key',
            'name' => 'name',
            'status' => ComicStatus::PUBLISHED,
        ]);
        $this->repository->save($comic);
    }

    /**
     * @return void
     */
    public function testModelToEntity(): void
    {
        $comicModel = ComicModel::find(1);
        $comic = $this->repository->modelToEntity($comicModel);
        $this->assertInstanceOf(Comic::class, $comic);
    }

    /**
     * @param array $attributes
     *
     * @return Comic
     */
    private function createEntity(array $attributes): Comic
    {
        return new Comic(
            null,
            Arr::get($attributes, 'key'),
            Arr::get($attributes, 'name'),
            Arr::get($attributes, 'status'),
        );
    }
}
