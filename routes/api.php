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
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::get('mpesa','MpesaPaymentController@deposite')->name('make.deposite');


Route::any('/handle-timeout', "HomeController@time_out_url")->name('handle_QueueTimeOutURL');

Route::any('/handle-deposit-result', 'HomeController@handle_result')->name('handle_deposit_result_api');


Route::any('/handle-withdraw-result', 'HomeController@withdraw_result')->name('handle_withdraw_resultresult_api');