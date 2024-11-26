<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GifController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);



Route::group(['middleware' => 'auth:sanctum'], function ($router) {

    Route::prefix('gifs')->group(function () {
        Route::get('/search', [GifController::class, 'search']);
        Route::get('/{id}', [GifController::class, 'getById']);
        Route::post('user/save', [GifController::class, 'save']);
        Route::delete('user/delete', [GifController::class, 'delete']);
    });
    Route::prefix('users')->group(function () {
        Route::get('/myuser', [UserController::class, 'myUser']);
    });
});
