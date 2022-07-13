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

Route::post('emails',[App\Http\Controllers\ApiController::class,'emails']);
Route::get('window',[App\Http\Controllers\ApiController::class,'window']);
Route::get('answers/today/carried',[App\Http\Controllers\ApiController::class,'survey_carried_today']);
Route::get('answers/month/carried',[App\Http\Controllers\ApiController::class,'survey_carried_month']);