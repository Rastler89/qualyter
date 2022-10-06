<?php

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

Route::get('window',[App\Http\Controllers\ApiController::class,'window']);
Route::get('evolution',[App\Http\Controllers\ApiController::class,'evolution']);
Route::get('answers/today/carried',[App\Http\Controllers\ApiController::class,'survey_carried_today']);
Route::get('answers/month/carried',[App\Http\Controllers\ApiController::class,'survey_carried_month']);
Route::get('answers/month/type',[App\Http\Controllers\ApiController::class,'answer_type']);
Route::get('answers/answered',[App\Http\Controllers\ApiController::class, 'answered']);
Route::post('leaderboard', [App\Http\Controllers\ApiController::class, 'leaderboard']);
Route::post('reports/targets', [App\Http\Controllers\ApiController::class, 'targets']);
Route::post('reports/incidences', [App\Http\Controllers\ApiController::class, 'incidences']);

Route::post('public/{id}', [App\Http\Controllers\PublicController::class,'info']);