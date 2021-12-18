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

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');
Route::get('email/verify/{id}', 'Api\VerificationController@verify')->name('verificationapi.verify');
Route::get('email/resend', 'Api\VerificationController@resend')->name('verificationapi.resend');

Route::group(['middleware' => 'auth:api'], function () {

    Route::get('user', 'Api\UserController@index');
    Route::get('user/{id}', 'Api\UserController@show');
    Route::post('user', 'Api\UserController@store');
    Route::put('user/{id}', 'Api\UserController@update');
    Route::delete('user/{id}', 'Api\UserController@destroy');

    Route::get('kamar', 'Api\KamarController@index');
    Route::get('kamar/{id}', 'Api\KamarController@show');
    Route::post('kamar', 'Api\KamarController@store');
    Route::put('kamar/{id}', 'Api\KamarController@update');
    Route::delete('kamar/{id}', 'Api\KamarController@destroy');

    Route::get('note', 'Api\NoteController@index');
    Route::get('note/{id}', 'Api\NoteController@show');
    Route::post('note', 'Api\NoteController@store');
    Route::put('note/{id}', 'Api\NoteController@update');
    Route::delete('note/{id}', 'Api\NoteController@destroy');

});
