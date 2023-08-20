<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Comic;

use App\Http\Requests\ApiRequest;
use Illuminate\Support\Facades\Route;

class ShowFormRequest extends ApiRequest
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
}
