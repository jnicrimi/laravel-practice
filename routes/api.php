<?php

declare(strict_types=1);

use App\Http\Controllers\V1\ComicsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'as' => 'v1.'], function () {
    Route::group(['prefix' => 'comics', 'as' => 'comics.'], function () {
        Route::get('/', [ComicsController::class, 'index'])->name('index');
        Route::get('/{comicId}', [ComicsController::class, 'show'])->name('show');
        Route::post('/', [ComicsController::class, 'store'])->name('store');
        Route::put('{comicId}', [ComicsController::class, 'update'])->name('update');
    });
});
