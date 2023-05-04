<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ComicsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var bool
     */
    protected $seed = true;

    /**
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get(route('api.v1.comics.index'));

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @dataProvider provideTestShow
     *
     * @param int $comicId
     * @param int $expected
     *
     * @return void
     */
    public function testShow(int $comicId, int $expected)
    {
        $response = $this->get(route('api.v1.comics.show', ['comicId' => $comicId]));

        $response->assertStatus($expected);
    }

    /**
     * @return array
     */
    public function provideTestShow(): array
    {
        return [
            '存在する comicId を指定した場合は 200 を返す' => [
                'comicId' => 1,
                'expected' => Response::HTTP_OK,
            ],
            '存在しない comicId を指定した場合は 404 を返す' => [
                'comicId' => 0,
                'expected' => Response::HTTP_NOT_FOUND,
            ],
        ];
    }
}
