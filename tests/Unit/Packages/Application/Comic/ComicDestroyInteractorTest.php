<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Application\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Packages\Application\Comic\ComicDestroyInteractor;
use Packages\UseCase\Comic\Destroy\ComicDestroyRequest;
use Packages\UseCase\Comic\Destroy\ComicDestroyResponse;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;
use Packages\UseCase\Comic\Exception\ComicUndeleteException;
use Tests\TestCase;

class ComicDestroyInteractorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var bool
     */
    protected $seed = true;

    /**
     * @var ComicDestroyInteractor
     */
    private $interactor;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->interactor = $this->app->make(ComicDestroyInteractor::class);
    }

    /**
     * @return void
     */
    public function testHandleSuccess(): void
    {
        $request = new ComicDestroyRequest();
        $request->setId(3);
        $response = $this->interactor->handle($request);
        $this->assertInstanceOf(ComicDestroyResponse::class, $response);
        $expected = [
            'comic' => [
                'id' => 3,
                'key' => 'default-key-3',
                'name' => 'default_name_3',
                'status' => [
                    'value' => 'closed',
                    'description' => '非公開',
                ],
            ],
        ];
        $actual = $response->build();
        $this->assertSame($expected, $actual);
    }

    /**
     * @return void
     */
    public function testHandleFailureByNotFound(): void
    {
        $this->expectException(ComicNotFoundException::class);
        $request = new ComicDestroyRequest();
        $request->setId(PHP_INT_MAX);
        $this->interactor->handle($request);
    }

    /**
     * @return void
     */
    public function testHandleFailureByUndelete(): void
    {
        $this->expectException(ComicUndeleteException::class);
        $request = new ComicDestroyRequest();
        $request->setId(1);
        $this->interactor->handle($request);
    }
}