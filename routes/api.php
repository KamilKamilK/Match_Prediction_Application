<?php

use App\Http\Controllers\PredictionsController;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::resource('/v1/predictions',PredictionsController::class)
    ->only(['index','store']);

Route::put('/v1/predictions/{id}/status', [PredictionsController::class, 'update']);


