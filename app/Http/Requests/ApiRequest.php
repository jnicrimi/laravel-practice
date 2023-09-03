<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Resources\ErrorResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ApiRequest extends FormRequest
{
    /**
     * @var string
     */
    public const CODE = 'failed-request-validation';

    public const MESSAGE = 'Failed request validation.';

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator): ErrorResource
    {
        $response['code'] = self::CODE;
        $response['message'] = self::MESSAGE;
        $response['errors'] = $validator->errors()->toArray();

        throw new HttpResponseException(
            response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
