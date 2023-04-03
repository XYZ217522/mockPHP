<?php

use App\Http\Controllers\GameRecordController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
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

Route::get('get-game-records', [GameRecordController::class, 'getGameRecordList']);
Route::post('update-game-records', [GameRecordController::class, 'updateGameRecord']);

//Route::prefix('/admin')->group(function () {
//    Route::delete('/records/delete/{id}', [GameRecordController::class, 'deleteGameRecord']);
//});


Route::post('auth/register', [UserController::class, 'register']);
Route::post('auth/find-user', [UserController::class, 'findUser']);

// post data api trigger pubsub datastore
Route::post('/order', [OrderController::class, 'addOrder']);
Route::post('/order/{orderNumber}', [OrderController::class, 'updateOrder']);


