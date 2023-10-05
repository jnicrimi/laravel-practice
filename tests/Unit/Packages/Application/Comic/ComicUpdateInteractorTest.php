<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Application\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Packages\Application\Comic\ComicUpdateInteractor;
use Packages\Domain\Comic\ComicStatus;
use Packages\UseCase\Comic\Exception\ComicDuplicateException;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;
use Packages\UseCase\Comic\Update\ComicUpdateRequest;
use Packages\UseCase\Comic\Update\ComicUpdateResponse;
use Tests\TestCase;

class ComicUpdateInteractorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var bool
     */
    protected $seed = true;

    /**
     * @var ComicUpdateInteractor
     */
    private $interactor;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->interactor = $this->app->make(ComicUpdateInteractor::class);
    }

    /**
     * @return void
     */
    public function testHandleSuccess(): void
    {
        $request = new ComicUpdateRequest();
        $request->setId(1)
            ->setKey('test-key-1')
            ->setName('test_name_1')
            ->setStatus(ComicStatus::CLOSED->value);
        $response = $this->interactor->handle($request);
        $this->assertInstanceOf(ComicUpdateResponse::class, $response);
        $expected = [
            'comic' => [
                'id' => 1,
                'key' => 'test-key-1',
                'name' => 'test_name_1',
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
        $request = new ComicUpdateRequest();
        $request->setId(PHP_INT_MAX)
            ->setKey('test-key-1')
            ->setName('test_name_1')
            ->setStatus(ComicStatus::CLOSED->value);
        $this->interactor->handle($request);
    }

    /**
     * @return void
     */
    public function testHandleFailureByDuplicateKey(): void
    {
        $this->expectException(ComicDuplicateException::class);
        $request = new ComicUpdateRequest();
        $request->setId(1)
            ->setKey('default-key-2')
            ->setName('test_name_1')
            ->setStatus(ComicStatus::CLOSED->value);
        $this->interactor->handle($request);
    }
}
