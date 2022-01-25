<?php

use App\Http\Controllers\PublisherController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SeriesController;
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

Route::prefix('v1')->post('/register', [RegisterController::class, 'register']);

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::apiResource('publishers', PublisherController::class);
    Route::apiResource('series', SeriesController::class)->except(['store']);
    Route::post('publishers/{publisher}/series', [SeriesController::class, 'store']);
});
