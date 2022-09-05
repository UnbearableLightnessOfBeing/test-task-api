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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// // });
// Route::group(['namespace' => 'App\Http\Controllers\Api'], function() {

//     Route::apiResource('users', UserController::class, ['parameters' => [
//         'users' => 'people'
//     ]]);
// });

Route::post('User/Register', [UserController::class, 'store']);
Route::get('User-{user}', [UserController::class, 'show']);
Route::put('User-{user}', [UserController::class, 'update']);
Route::patch('User-{user}', [UserController::class, 'update']);
Route::delete('User-{user}', [UserController::class, 'destroy']);


