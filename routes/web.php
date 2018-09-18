<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');
Route::get('/terms', 'HomeController@index')->name('terms');


/**
 * Admin
 */
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

/**
 * Auth
 */
Auth::routes();
Route::get('/register/verify/{token}', 'Auth\RegisterController@verify');

/**
 * Users
 */
Route::patch('/users',  ['as' => 'users.update', 'uses' => 'UserController@update', 'middleware' => 'auth']);
Route::patch('/users/password',  ['as' => 'users.password.update', 'uses' => 'UserController@updatePassword', 'middleware' => 'auth']);


/**
 * Groups
 */
Route::get('/groups', 'GroupController@index')->name('groups');
Route::get('/groups/{slug}', 'GroupController@show')->name('group');

/**
 * Personal cabinet
 */
Route::group(['prefix' => 'settings', 'middleware' => 'auth'], function () {

    Route::get('/', function(){
        return redirect()->route('settings.personal');
    })->name('settings');

    Route::get('/personal', ['as' => 'settings.personal', 'uses' => 'UserController@edit']);
    Route::get('/password', ['as' => 'settings.password', 'uses' => 'UserController@password']);
    Route::get('/profiles', ['as' => 'settings.games_profiles', 'uses' => 'UserController@profiles']);

    /*
    Route::get('/profile', ['as' => 'profile', 'uses' => 'UserController@edit']);
    Route::patch('/profile/update',  ['as' => 'users.update', 'uses' => 'UserController@update']);
    Route::get('/accounts', ['as' => 'accounts', 'uses' => 'LkController@accounts']);
    Route::get('/withdrawals/verify', ['as' => 'withdrawals.verify.form','uses' => 'LkController@withdrawalsVerify']);
    Route::get('/withdrawals/verify/{token}', 'WithdrawalController@verifyGet');
    Route::get('/withdrawals', ['as' => 'withdrawals', 'uses' => 'LkController@withdrawals']);
    Route::get('/subpartners', ['as' => 'subpartners', 'uses' => 'LkController@subpartners']);
    Route::get('/balance', ['as' => 'balance', 'uses' => 'LkController@balance']);
    Route::get('/robots', ['as' => 'lk-robots', 'uses' => 'LkController@robots']);*/
});