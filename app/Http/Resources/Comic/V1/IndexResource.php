<?php

declare(strict_types=1);

namespace App\Http\Resources\Comic\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'comics' => $this->resource['comics'],
            ],
        ];
    }
}
