<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\DreamerController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
    
    Route::prefix('group')->group(function () {
        Route::get('/', [GroupController::class, 'index']);
        Route::post('/', [GroupController::class, 'store']);
        Route::get('/{id}', [GroupController::class, 'show']);
        Route::get('/search-for-user/{user}', [GroupController::class, 'searchForUser']);
    });

    Route::prefix('dreamer')->group(function () {
        Route::get('/', [DreamerController::class, 'index']);
        Route::post('/', [DreamerController::class, 'store']);
        Route::get('/{id}', [DreamerController::class, 'show']);
        Route::post('/change-group/{id}', [DreamerController::class, 'changeGroup']);
    });
});
