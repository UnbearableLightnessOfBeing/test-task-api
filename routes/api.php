<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

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

Route::post('users/register', [UserController::class, 'store']);
Route::get('users/{user}', [UserController::class, 'show'])->middleware(['userIsAuthorized', 'userIsBlocked']);
Route::put('users/{user}', [UserController::class, 'update'])->middleware(['userIsAuthorized', 'userIsBlocked']);
Route::patch('users/{user}', [UserController::class, 'update'])->middleware(['userIsAuthorized', 'userIsBlocked']);
Route::delete('users/{user}', [UserController::class, 'destroy'])->middleware(['userIsAuthorized', 'userIsBlocked']);


