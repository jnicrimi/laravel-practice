<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers\V1;

use App\Http\Errors\ComicError;
use App\Http\Errors\CommonError;
use App\Http\Errors\ValidationError;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicStatus;
use Packages\Infrastructure\Repository\Comic\ComicRepository;
use Tests\TestCase;

class ComicsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var bool
     */
    protected $seed = true;

    /**
     * @var ComicRepository
     */
    private $comicRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->comicRepository = $this->app->make(ComicRepository::class);
    }

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
     * @dataProvider provideCreate
     *
     * @param array $formData
     * @param array $expected
     *
     * @return void
     */
    public function testCreate(array $formData, array $expected)
    {
        $response = $this->post(route('api.v1.comics.create'), $formData);
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
     * @return void
     */
    public function testCreateFailureByDuplicate()
    {
        $comicId = new ComicId(1);
        $registeredComic = $this->comicRepository->find($comicId);
        $formData = [
            'key' => $registeredComic->getKey()->getValue(),
            'name' => 'test_name_1',
            'status' => ComicStatus::DRAFT->value,
        ];
        $response = $this->post(route('api.v1.comics.create'), $formData);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'code',
            'message',
        ]);
        $response->assertJson([
            'code' => ComicError::ComicDuplicate->code(),
            'message' => ComicError::ComicDuplicate->message(),
        ]);
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
    public static function provideCreate(): array
    {
        return [
            '正常系' => [
                'formData' => [
                    'name' => 'test_name_1',
                    'key' => 'test-key-1',
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
                    'name' => 'test_name_1',
                    'key' => null,
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
                    'name' => 'test_name_1',
                    'key' => '',
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
                    'name' => 'test_name_1',
                    'key' => str_repeat('a', 256),
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
                    'name' => 'test_name_1',
                    'key' => 'test_key_1',
                    'status' => ComicStatus::PUBLISHED->value,
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
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
                    'name' => null,
                    'key' => 'test-key-1',
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
                    'name' => '',
                    'key' => 'test-key-1',
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
                    'name' => str_repeat('a', 256),
                    'key' => 'test-key-1',
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
                    'name' => 'test_name_1',
                    'key' => 'test-key-1',
                ],
                'expected' => [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'code' => ValidationError::FailedRequestValidation->code(),
                    'message' => ValidationError::FailedRequestValidation->message(),
                ],
            ],
            'status に null を指定' => [
                'formData' => [
                    'name' => 'test_name_1',
                    'key' => 'test-key-1',
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
                    'name' => 'test_name_1',
                    'key' => 'test-key-1',
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
