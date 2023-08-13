<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Infrastructure\Comic;

use App\Models\Comic as ComicModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\Comics;
use Packages\Domain\Comic\ComicStatus;
use Packages\Infrastructure\Repository\Comic\ComicRepository;
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
    public function testPaginate(): void
    {
        $comics = $this->repository->paginate(5);
        $this->assertInstanceOf(Comics::class, $comics);
    }

    /**
     * @dataProvider  provideSave
     *
     * @param array $attributes
     *
     * @return void
     */
    public function testSave($attributes): void
    {
        $comic = $this->repository->save($this->createEntity($attributes));
        $this->assertInstanceOf(Comic::class, $comic);
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
     * @return array
     */
    public static function provideSave(): array
    {
        return [
            [
                [
                    'id' => null,
                    'key' => 'key',
                    'name' => 'name',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
            ],
            [
                [
                    'id' => 1,
                    'key' => 'key',
                    'name' => 'name',
                    'status' => ComicStatus::DRAFT->value,
                ],
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
            ComicStatus::from(Arr::get($attributes, 'status'))
        );
    }
}
