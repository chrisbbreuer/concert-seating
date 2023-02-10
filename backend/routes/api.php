<?php

use App\Http\Controllers\ClearGuestAction;
use App\Http\Controllers\GenerateGuestAction;
use App\Http\Controllers\RandomMatrixController;
use App\Http\Controllers\RetrieveGuestsAction;
use App\Http\Controllers\RetrievePackagesAction;
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

Route::get('/random-matrix', RandomMatrixController::class);
Route::post('/guest', RetrieveGuestsAction::class);
Route::post('/guest-generate', GenerateGuestAction::class);
Route::post('/guest-clear', ClearGuestAction::class);
Route::get('/guest-packages', RetrievePackagesAction::class);
