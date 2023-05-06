<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Application\Comic\Index;

use Packages\Application\Comic\Index\ComicIndexInteractor;
use Packages\UseCase\Comic\Index\ComicIndexResponse;
use Tests\TestCase;

class ComicIndexInteractorTest extends TestCase
{
    /**
     * @var ComicIndexInteractor
     */
    private $interactor;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->interactor = $this->app->make(ComicIndexInteractor::class);
    }

    /**
     * @return void
     */
    public function testHandleSucceeded(): void
    {
        $response = $this->interactor->handle();
        $this->assertInstanceOf(ComicIndexResponse::class, $response);
    }
}
