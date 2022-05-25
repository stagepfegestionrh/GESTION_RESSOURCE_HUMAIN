<?php

use Illuminate\Http\Request;

/*php
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

Route::apiResources(['user' => 'API\UserController']);
Route::get('profile', 'API\UserController@profile');
Route::put('profile', 'API\UserController@updateProfile');
Route::get('division','API\DivisionController@index');
Route::post('division','API\DivisionController@store');
Route::get('UserDivisions','API\DivisionController@UserDivisions');
Route::put('division/{id}', 'API\DivisionController@update');
Route::get('service','API\ServController@index');
Route::post('service','API\ServController@store');
Route::get('UserServices','API\ServController@UserServices');

