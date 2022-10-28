<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

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

Route::post('/register', [MainController::class, 'register']);
Route::post('/login', [MainController::class, 'login'])->name('login');
Route::get('get-users', [MainController::class, 'allUsers']);
Route::post('/update-user-status', [MainController::class, 'updateUserStatus']);



