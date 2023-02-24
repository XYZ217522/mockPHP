<?php

use App\Http\Controllers\GameRecordController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('/', fn () => view('welcome'));
//Route::get('/', function () {
//    return view('welcome');
//});


Route::get('/', IndexController::class);
Route::view('/addRecord', 'addRecord');
Route::post('update-game-records', [GameRecordController::class, 'updateGameRecord'])->name('update-game-records');

Route::prefix('/admin')->group(function () {
    Route::delete('/records/delete/{id}', [GameRecordController::class, 'deleteGameRecord'])->name('admin.record.delete');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
