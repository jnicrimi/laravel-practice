<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Comic;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DestroyResource extends JsonResource
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
                'comic' => $this->resource['comic'],
            ],
        ];
    }
}
