<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Application\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Packages\Application\Comic\ComicCreateInteractor;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicStatus;
use Packages\Infrastructure\Repository\Comic\ComicRepository;
use Packages\UseCase\Comic\Create\ComicCreateRequest;
use Packages\UseCase\Comic\Create\ComicCreateResponse;
use Packages\UseCase\Comic\Exception\ComicDuplicateException;
use Tests\TestCase;

class ComicCreateInteractorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var bool
     */
    protected $seed = true;

    /**
     * @var ComicCreateInteractor
     */
    private $interactor;

    /**
     * @var ComicRepository
     */
    private $comicRepository;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->interactor = $this->app->make(ComicCreateInteractor::class);
        $this->comicRepository = $this->app->make(ComicRepository::class);
    }

    /**
     * @return void
     */
    public function testHandleSuccess(): void
    {
        $request = new ComicCreateRequest();
        $request->setKey('test-key-1')
            ->setName('test_name_1')
            ->setStatus(ComicStatus::CLOSED->value);
        $response = $this->interactor->handle($request);
        $this->assertInstanceOf(ComicCreateResponse::class, $response);
    }

    /**
     * @return void
     */
    public function testHandleFailureByDuplicate(): void
    {
        $this->expectException(ComicDuplicateException::class);
        $comicId = new ComicId(1);
        $registeredComic = $this->comicRepository->find($comicId);
        $request = new ComicCreateRequest();
        $request->setKey($registeredComic->getKey()->getValue())
            ->setName('test_name_1')
            ->setStatus(ComicStatus::CLOSED->value);
        $this->interactor->handle($request);
    }
}