<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Application\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Packages\Application\Comic\ComicShowInteractor;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;
use Packages\UseCase\Comic\Show\ComicShowRequest;
use Packages\UseCase\Comic\Show\ComicShowResponse;
use Tests\TestCase;

class ComicShowInteractorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var bool
     */
    protected $seed = true;

    /**
     * @var ComicShowInteractor
     */
    private $interactor;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->interactor = $this->app->make(ComicShowInteractor::class);
    }

    /**
     * @return void
     */
    public function testHandleSucceeded(): void
    {
        $request = new ComicShowRequest();
        $request->setComicId(1);
        $response = $this->interactor->handle($request);
        $this->assertInstanceOf(ComicShowResponse::class, $response);
    }

    /**
     * @return void
     */
    public function testHandleFailed(): void
    {
        $this->expectException(ComicNotFoundException::class);
        $request = new ComicShowRequest();
        $request->setComicId(PHP_INT_MAX);
        $response = $this->interactor->handle($request);
    }
}
