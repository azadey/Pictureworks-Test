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


Route::post('user-comment', 'Api\Modules\UserComment\UserCommentController@createUserComment');

Route::get('user-comment/{id}', 'Api\Modules\UserComment\UserCommentController@getUserComment');

Route::patch('user-comment/{id}', 'Api\Modules\UserComment\UserCommentController@updateUserComment');

Route::delete('user-comment/{id}', 'Api\Modules\UserComment\UserCommentController@deleteUserComment');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
