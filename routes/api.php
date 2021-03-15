<?php

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

Route::prefix('/v1')->group(static function() {
    Route::post('/user/add', 'UsersController@store');

    Route::prefix('/ib')->group(static function() {
        Route::put('/updateTotalBalance', 'UpdateBalanceController@update');
        Route::get('/listNAB', 'NetAssetsController@index');
        Route::post('/topup', 'TopUpController@create');
        Route::post('/withdraw', 'WithdrawController@create');
        Route::get('/member', 'UsersController@index');
    });
});