<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//Route for login page
Route::get('/', function () {
    //return view('reports.income_statement');
    return Redirect::to('auth/login');
});
// Authentication routes...
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/login', ['as'=>'login','uses'=>'Auth\AuthController@getLogin']);
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', ['as'=>'logout','uses' => 'Auth\AuthController@getLogout']);
Route::get('auth/verify/{id}', ['as'=>'verify','uses' => 'registerverifier\RegisterVerifierController@getVerifier']);
Route::post('auth/verify', ['as'=>'verify','uses' => 'registerverifier\RegisterVerifierController@postVerifier']);

// Uses authentication middleware, to avoid uneccessary access if not login
Route::group(['middleware' => 'auth' , 'web'], function () {
    Route::resource('users','user\UserController');
    Route::resource('usertypes','usertype\UserTypeController');
    Route::resource('homeowners','homeownerinformation\HomeOwnerInformationController');
    Route::resource('homeownermembers','homeownermember\HomeOwnerMemberController');
    Route::get('homeownermembers/create/{id}','homeownermember\HomeOwnerMemberController@create');
    Route::resource('invoice','invoice\InvoiceController');
    Route::resource('receipt','receipt\ReceiptController');
    Route::get('receipt/create/{id}','receipt\ReceiptController@create');
    Route::resource('expense','expense\ExpenseController');
    Route::resource('account','accountInformation\AccountInformationController');
    Route::resource('accounttitle','accountTitle\AccountTitleController');

    //Report viewing
    Route::get('reports/incomestatement',['as'=>'incomestatement','uses'=>'reports\ReportController@getGenerateIncomeStatement']);
    Route::post('reports/incomestatement','reports\ReportController@postGenerateIncomeStatement');
    

});
