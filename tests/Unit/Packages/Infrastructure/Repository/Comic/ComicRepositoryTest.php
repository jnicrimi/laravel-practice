<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Infrastructure\Repository\Comic;

use App\Models\Comic as ComicModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\Comics;
use Packages\Domain\Comic\ComicStatus;
use Packages\Infrastructure\EntityFactory\Comic\ComicEntityFactory;
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
     * @var ComicEntityFactory
     */
    private $entityFactory;

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
        $this->entityFactory = $this->app->make(ComicEntityFactory::class);
    }

    /**
     * @return void
     */
    public function testFindSuccess(): void
    {
        $comicId = new ComicId(1);
        $comic = $this->repository->find($comicId);
        $this->assertInstanceOf(Comic::class, $comic);
    }

    /**
     * @return void
     */
    public function testFindFailure(): void
    {
        $comicId = new ComicId(PHP_INT_MAX);
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
     * @dataProvider provideSave
     *
     * @param array $attributes
     *
     * @return void
     */
    public function testSave($attributes): void
    {
        $entity = $this->entityFactory->create($attributes);
        $comic = $this->repository->save($entity);
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
                    'created_at' => null,
                    'updated_at' => null,
                ],
            ],
            [
                [
                    'id' => 1,
                    'key' => 'key',
                    'name' => 'name',
                    'status' => ComicStatus::DRAFT->value,
                    'created_at' => '2023-01-01 00:00:00',
                    'updated_at' => '2023-12-31 23:59:59',
                ],
            ],
        ];
    }
}
