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
        $response->assertJsonStructure([
            'data' => [
                'comics' => [
                    0 => [
                        'id',
                        'key',
                        'name',
                        'status' => [
                            'value',
                            'description',
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * @dataProvider provideShow
     *
     * @param int $comicId
     * @param int $expected
     *
     * @return void
     */
    public function testShow(int $comicId, int $expected)
    {
        $this->seed();
        $response = $this->get(route('api.v1.comics.show', ['comicId' => $comicId]));
        $response->assertStatus($expected);
        if ($expected === Response::HTTP_OK) {
            $response->assertJsonStructure([
                'data' => [
                    'comic' => [
                        'id',
                        'key',
                        'name',
                        'status' => [
                            'value',
                            'description',
                        ],
                    ],
                ],
            ]);
        }
    }

    /**
     * @return array
     */
    public static function provideShow(): array
    {
        return [
            '存在する comicId を指定した場合は 200 を返す' => [
                'comicId' => 1,
                'expected' => Response::HTTP_OK,
            ],
            '存在しない comicId を指定した場合は 404 を返す' => [
                'comicId' => PHP_INT_MAX,
                'expected' => Response::HTTP_NOT_FOUND,
            ],
            'comicId に 0 を指定した場合は 422 を返す' => [
                'comicId' => 0,
                'expected' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            'comicId に負の値を指定した場合は 422 を返す' => [
                'comicId' => -1,
                'expected' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
        ];
    }
}
