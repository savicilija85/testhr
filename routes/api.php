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

Route::options('/', 'PriceController@getPrice')->middleware('cors');
Route::get('/', 'PriceController@getPrice')->middleware('cors');

Route::options('/showVerificationCodePage', 'Auth\RegisterController@showVerificationCodePage')->middleware('cors');
Route::post('/showVerificationCodePage', 'Auth\RegisterController@showVerificationCodePage')->middleware('cors');

Route::options('/registerUser', 'Auth\RegisterController@registerUser')->middleware('cors');
Route::post('/registerUser', 'Auth\RegisterController@registerUser')->middleware('cors');

Route::post('/login', 'Auth\LoginController@login');
Route::post('/authenticate', 'Auth\LoginController@getAuthenticatedUser');

//Route::post('/user/saveOrder', 'BuySellController@saveOrder');
Route::post('/user/saveOrder', 'BuySellController@saveOrderTest');

Route::get('/user/getAccounts', 'BuySellController@getAccounts');

Route::get('/user/getName', 'UserController@getName');