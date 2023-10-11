<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Application\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Packages\Application\Comic\ComicStoreInteractor;
use Packages\Domain\Comic\ComicStatus;
use Packages\UseCase\Comic\Exception\ComicDuplicateException;
use Packages\UseCase\Comic\Store\ComicStoreRequest;
use Packages\UseCase\Comic\Store\ComicStoreResponse;
use Tests\TestCase;

class ComicStoreInteractorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var bool
     */
    protected $seed = true;

    /**
     * @var ComicStoreInteractor
     */
    private $interactor;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->interactor = $this->app->make(ComicStoreInteractor::class);
    }

    /**
     * @return void
     */
    public function testHandleSuccess(): void
    {
        $request = new ComicStoreRequest();
        $request->setKey('test-key-1')
            ->setName('test_name_1')
            ->setStatus(ComicStatus::CLOSED->value);
        $response = $this->interactor->handle($request);
        $this->assertInstanceOf(ComicStoreResponse::class, $response);
        $expected = [
            'comic' => [
                'id' => $response->build()['comic']['id'],
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
    public function testHandleFailureByDuplicateKey(): void
    {
        $this->expectException(ComicDuplicateException::class);
        $request = new ComicStoreRequest();
        $request->setKey('default-key-1')
            ->setName('test_name_1')
            ->setStatus(ComicStatus::CLOSED->value);
        $this->interactor->handle($request);
    }
}