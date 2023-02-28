<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;

use Illuminate\Http\Response;
use Tests\TestCase;

class ComicsControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get(route('api.v1.comics.index'));

        $response->assertStatus(Response::HTTP_OK);
    }
}
