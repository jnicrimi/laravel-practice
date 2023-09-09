<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Application\Comic;

use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Packages\Application\Comic\ComicShowInteractor;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;
use Packages\UseCase\Comic\Show\ComicShowRequest;
use Packages\UseCase\Comic\Show\ComicShowResponse;
use Tests\TestCase;
use TypeError;

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
    public function testHandleSuccess(): void
    {
        $request = new ComicShowRequest();
        $request->setComicId(1);
        $response = $this->interactor->handle($request);
        $this->assertInstanceOf(ComicShowResponse::class, $response);
    }

    /**
     * @dataProvider provideHandleFailure
     *
     * @param mixed $comicId
     * @param array $expected
     *
     * @return void
     */
    public function testHandleFailure(mixed $comicId, array $expected): void
    {
        $this->expectException($expected['exception']);
        $request = new ComicShowRequest();
        $request->setComicId($comicId);
        $response = $this->interactor->handle($request);
    }

    /**
     * @return array
     */
    public static function provideHandleFailure(): array
    {
        return [
            [
                'comicId' => PHP_INT_MAX,
                'expected' => [
                    'exception' => ComicNotFoundException::class,
                ],
            ],
            [
                'comicId' => 0,
                'expected' => [
                    'exception' => InvalidArgumentException::class,
                ],
            ],
            [
                'comicId' => -1,
                'expected' => [
                    'exception' => InvalidArgumentException::class,
                ],
            ],
            [
                'comicId' => 'a',
                'expected' => [
                    'exception' => TypeError::class,
                ],
            ],
        ];
    }
}
