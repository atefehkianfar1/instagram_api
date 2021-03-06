<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('/v1')->group(function () {
    Route::post('login','SignInController@login');
    Route::prefix('/user')->group(function () {
        Route::post('search','AppController@user_search');
        Route::get('profile','AppController@user_profile');
    });
    Route::prefix('/post')->group(function () {
        Route::get('mine','AppController@post_mine');
        Route::post('like_dislike','AppController@post_like');
    });
});

