<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Infrastructure\Repository\Comic;

use App\Models\Comic as ComicModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicIdIsNotSetException;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\Comics;
use Packages\Domain\Comic\ComicStatus;
use Packages\Infrastructure\QueryBuilder\Comic\Index\ComicSearchQueryBuilder;
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
    public function testFindByKeySuccess(): void
    {
        $comicKey = new ComicKey('default-key-1');
        $comic = $this->repository->findByKey($comicKey);
        $this->assertInstanceOf(Comic::class, $comic);
    }

    /**
     * @dataProvider provideFindByKeyFailure
     *
     * @param string $comicKey
     * @param int|null $ignoreComicId
     *
     * @return void
     */
    public function testFindByKeyFailure(string $comicKey, ?int $ignoreComicId): void
    {
        $comicKey = new ComicKey($comicKey);
        if ($ignoreComicId !== null) {
            $ignoreComicId = new ComicId($ignoreComicId);
        }
        $comic = $this->repository->findByKey($comicKey, $ignoreComicId);
        $this->assertNull($comic);
    }

    /**
     * @return void
     */
    public function testPaginate(): void
    {
        $queryBuilder = new ComicSearchQueryBuilder();
        $queryBuilder->setKey('default-key-1');
        $queryBuilder->setName('default_name_1');
        $queryBuilder->setStatus(['published']);
        $query = $queryBuilder->build();
        $comics = $this->repository->paginate($query, 5);
        $this->assertInstanceOf(Comics::class, $comics);
    }

    /**
     * @return void
     */
    public function testCreateSuccess(): void
    {
        $entity = new Comic(
            null,
            new ComicKey('key'),
            new ComicName('name'),
            ComicStatus::from('draft'),
            null,
            null
        );
        $comic = $this->repository->create($entity);
        $this->assertInstanceOf(Comic::class, $comic);
    }

    /**
     * @return void
     */
    public function testCreateFailure(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('ComicId is already set.');
        $entity = new Comic(
            new ComicId(1),
            new ComicKey('key'),
            new ComicName('name'),
            ComicStatus::from('published'),
            null,
            null
        );
        $this->repository->create($entity);
    }

    /**
     * @return void
     */
    public function testUpdateSuccess(): void
    {
        $entity = new Comic(
            new ComicId(1),
            new ComicKey('key'),
            new ComicName('name'),
            ComicStatus::from('published'),
            Carbon::parse('2023-01-01 00:00:00'),
            Carbon::parse('2023-12-31 23:59:59')
        );
        $comic = $this->repository->update($entity);
        $this->assertInstanceOf(Comic::class, $comic);
    }

    /**
     * @return void
     */
    public function testUpdateFailure(): void
    {
        $this->expectException(ComicIdIsNotSetException::class);
        $entity = new Comic(
            null,
            new ComicKey('key'),
            new ComicName('name'),
            ComicStatus::from('published'),
            null,
            null
        );
        $this->repository->update($entity);
    }

    /**
     * @return void
     */
    public function testDelete(): void
    {
        $comicModel = ComicModel::find(3);
        $comic = $this->repository->modelToEntity($comicModel);
        if ($comic->canDelete() === false) {
            $this->fail('comic cannot be deleted.');
        }
        $this->repository->delete($comic);
        $deletedComicModel = ComicModel::find(3);
        $this->assertNull($deletedComicModel);
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
    public static function provideFindByKeyFailure(): array
    {
        return [
            [
                'comicKey' => 'dummy',
                'ignoreComicId' => null,
            ],
            [
                'comicKey' => 'default-key-1',
                'ignoreComicId' => 1,
            ],
        ];
    }
}
