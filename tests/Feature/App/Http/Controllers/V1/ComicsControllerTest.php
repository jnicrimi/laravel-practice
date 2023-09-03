<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers\V1;

use App\Http\Errors\ComicError;
use App\Http\Errors\CommonError;
use App\Http\Errors\ValidationError;
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
     * @param mixed $comicId
     * @param array $expected
     *
     * @return void
     */
    public function testShow(mixed $comicId, array $expected)
    {
        $this->seed();
        $response = $this->get(route('api.v1.comics.show', ['comicId' => $comicId]));
        $response->assertStatus($expected['status']);
        if ($expected['status'] === Response::HTTP_OK) {
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
        } else {
            $response->assertJsonStructure([
                'code',
                'message',
            ]);
            $response->assertJson([
                'code' => $expected['code'],
                'message' => $expected['message'],
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
                'expected' => [
                    'status' => Response::HTTP_OK,
                ],
            ],
            '存在しない comicId を指定した場合は 404 を返す' => [
                'comicId' => PHP_INT_MAX,
                'expected' => [
                    'status' => Response::HTTP_NOT_FOUND,
                    'code' => ComicError::ComicNotFound->code(),
                    'message' => ComicError::ComicNotFound->message(),
                ],
            ],
            'comicId に 0 を指定した場合は 422 を返す' => [
                'comicId' => 0,
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => CommonError::InvalidArgument->code(),
                    'message' => CommonError::InvalidArgument->message(),
                ],
            ],
            'comicId に負の値を指定した場合は 422 を返す' => [
                'comicId' => -1,
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => CommonError::InvalidArgument->code(),
                    'message' => CommonError::InvalidArgument->message(),
                ],
            ],
            'comicId に文字列を指定した場合は 422 を返す' => [
                'comicId' => 'a',
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
        ];
    }
}
