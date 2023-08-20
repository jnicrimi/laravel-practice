<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Comic;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Route;

class ShowFormRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'comic_id' => [
                'required',
                'integer',
            ],
        ];
    }

    /**
     * @return array
     */
    public function validationData()
    {
        return array_merge($this->request->all(), [
            'comic_id' => Route::input('comicId'),
        ]);
    }

    /**
     * @param Validator $validator
     *
     * @throw HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([], 422)
        );
    }
}
