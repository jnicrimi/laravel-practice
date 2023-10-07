<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers\V1;

use App\Http\Errors\ComicError;
use App\Http\Errors\CommonError;
use App\Http\Errors\ValidationError;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Packages\Domain\Comic\ComicStatus;
use Tests\TestCase;

class ComicsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var bool
     */
    protected $seed = true;

    /**
     * @dataProvider provideIndex
     *
     * @param array $params
     * @param array $expected
     *
     * @return void
     */
    public function testIndex(array $params, array $expected)
    {
        $response = $this->get(route('api.v1.comics.index', $params));
        $response->assertStatus($expected['status']);
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
     * @dataProvider provideStore
     *
     * @param array $formData
     * @param array $expected
     *
     * @return void
     */
    public function testStore(array $formData, array $expected)
    {
        $response = $this->post(route('api.v1.comics.store'), $formData);
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
     * @dataProvider provideUpdate
     *
     * @param mixed $comicId
     * @param array $formData
     * @param array $expected
     *
     * @return void
     */
    public function testUpdate(mixed $comicId, array $formData, array $expected)
    {
        $response = $this->put(route('api.v1.comics.update', ['comicId' => $comicId]), $formData);
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
    public static function provideIndex(): array
    {
        return [
            '指定なし' => [
                'params' => [],
                'expected' => [
                    'status' => Response::HTTP_OK,
                ],
            ],
            'key を指定' => [
                'params' => [
                    'key' => 'default-key-1',
                ],
                'expected' => [
                    'status' => Response::HTTP_OK,
                ],
            ],
            'name を指定' => [
                'params' => [
                    'name' => 'default_name_1',
                ],
                'expected' => [
                    'status' => Response::HTTP_OK,
                ],
            ],
            'status を指定' => [
                'params' => [
                    'status' => [ComicStatus::PUBLISHED->value],
                ],
                'expected' => [
                    'status' => Response::HTTP_OK,
                ],
            ],
            '全てのパラメータを指定' => [
                'params' => [
                    'key' => 'default-key-1',
                    'name' => 'default_name_1',
                    'status' => [ComicStatus::PUBLISHED->value],
                ],
                'expected' => [
                    'status' => Response::HTTP_OK,
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public static function provideShow(): array
    {
        return [
            '存在する comicId を指定' => [
                'comicId' => 1,
                'expected' => [
                    'status' => Response::HTTP_OK,
                ],
            ],
            '存在しない comicId を指定' => [
                'comicId' => PHP_INT_MAX,
                'expected' => [
                    'status' => Response::HTTP_NOT_FOUND,
                    'code' => ComicError::ComicNotFound->code(),
                    'message' => ComicError::ComicNotFound->message(),
                ],
            ],
            'comicId に 0 を指定' => [
                'comicId' => 0,
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => CommonError::InvalidArgument->code(),
                    'message' => CommonError::InvalidArgument->message(),
                ],
            ],
            'comicId に負の値を指定' => [
                'comicId' => -1,
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => CommonError::InvalidArgument->code(),
                    'message' => CommonError::InvalidArgument->message(),
                ],
            ],
            'comicId に文字列を指定' => [
                'comicId' => 'a',
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public static function provideStore(): array
    {
        return [
            '正常系' => [
                'formData' => [
                    'key' => 'test-key-1',
                    'name' => 'test_name_1',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_OK,
                ],
            ],
            'key が未設定' => [
                'formData' => [
                    'name' => 'test_name_1',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'key に null を指定' => [
                'formData' => [
                    'key' => null,
                    'name' => 'test_name_1',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'key に空文字を指定' => [
                'formData' => [
                    'key' => '',
                    'name' => 'test_name_1',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'key の文字数が最大値を超えている' => [
                'formData' => [
                    'key' => str_repeat('a', 256),
                    'name' => 'test_name_1',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'key の書式が不正' => [
                'formData' => [
                    'key' => 'test_key_1',
                    'name' => 'test_name_1',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'key が重複' => [
                'formData' => [
                    'key' => 'default-key-1',
                    'name' => 'test_name_1',
                    'status' => 'draft',
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ComicError::ComicDuplicate->code(),
                    'message' => ComicError::ComicDuplicate->message(),
                ],
            ],
            'name が未設定' => [
                'formData' => [
                    'key' => 'test-key-1',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'name に null を指定' => [
                'formData' => [
                    'key' => 'test-key-1',
                    'name' => null,
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'name に空文字を指定' => [
                'formData' => [
                    'key' => 'test-key-1',
                    'name' => '',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'name の文字数が最大値を超えている' => [
                'formData' => [
                    'key' => 'test-key-1',
                    'name' => str_repeat('a', 256),
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'status が未設定' => [
                'formData' => [
                    'key' => 'test-key-1',
                    'name' => 'test_name_1',
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'status に null を指定' => [
                'formData' => [
                    'key' => 'test-key-1',
                    'name' => 'test_name_1',
                    'status' => null,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'status に不正な値を指定' => [
                'formData' => [
                    'key' => 'test-key-1',
                    'name' => 'test_name_1',
                    'status' => 'invalid',
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public static function provideUpdate(): array
    {
        return [
            '正常系' => [
                'comicId' => 1,
                'formData' => [
                    'key' => 'test-key-1',
                    'name' => 'test_name_1',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_OK,
                ],
            ],
            '存在しない comicId を指定' => [
                'comicId' => PHP_INT_MAX,
                'formData' => [
                    'key' => 'test-key-1',
                    'name' => 'test_name_1',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_NOT_FOUND,
                    'code' => ComicError::ComicNotFound->code(),
                    'message' => ComicError::ComicNotFound->message(),
                ],
            ],
            'comicId に 0 を指定' => [
                'comicId' => 0,
                'formData' => [
                    'key' => 'test-key-1',
                    'name' => 'test_name_1',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => CommonError::InvalidArgument->code(),
                    'message' => CommonError::InvalidArgument->message(),
                ],
            ],
            'comicId に負の値を指定' => [
                'comicId' => -1,
                'formData' => [
                    'key' => 'test-key-1',
                    'name' => 'test_name_1',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => CommonError::InvalidArgument->code(),
                    'message' => CommonError::InvalidArgument->message(),
                ],
            ],
            'comicId に文字列を指定' => [
                'comicId' => 'a',
                'formData' => [
                    'key' => 'test-key-1',
                    'name' => 'test_name_1',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'key が未設定' => [
                'comicId' => 1,
                'formData' => [
                    'name' => 'test_name_1',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'key に空文字を指定' => [
                'comicId' => 1,
                'formData' => [
                    'key' => '',
                    'name' => 'test_name_1',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'key の文字数が最大値を超えている' => [
                'comicId' => 1,
                'formData' => [
                    'key' => str_repeat('a', 256),
                    'name' => 'test_name_1',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'key の書式が不正' => [
                'comicId' => 1,
                'formData' => [
                    'key' => 'test_key_1',
                    'name' => 'test_name_1',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'key が重複' => [
                'comicId' => 1,
                'formData' => [
                    'key' => 'default-key-2',
                    'name' => 'test_name_1',
                    'status' => 'draft',
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ComicError::ComicDuplicate->code(),
                    'message' => ComicError::ComicDuplicate->message(),
                ],
            ],
            'name が未設定' => [
                'comicId' => 1,
                'formData' => [
                    'key' => 'test-key-1',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'name に null を指定' => [
                'comicId' => 1,
                'formData' => [
                    'key' => 'test-key-1',
                    'name' => null,
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'name に空文字を指定' => [
                'comicId' => 1,
                'formData' => [
                    'key' => 'test-key-1',
                    'name' => '',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'name の文字数が最大値を超えている' => [
                'comicId' => 1,
                'formData' => [
                    'key' => 'test-key-1',
                    'name' => str_repeat('a', 256),
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'status が未設定' => [
                'comicId' => 1,
                'formData' => [
                    'key' => 'test-key-1',
                    'name' => 'test_name_1',
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'status に null を指定' => [
                'comicId' => 1,
                'formData' => [
                    'key' => 'test-key-1',
                    'name' => 'test_name_1',
                    'status' => null,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'status に不正な値を指定' => [
                'comicId' => 1,
                'formData' => [
                    'key' => 'test-key-1',
                    'name' => 'test_name_1',
                    'status' => 'invalid',
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
        ];
    }
}
