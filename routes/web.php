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
 * Games
 */
Route::get('/games', 'GameController@index')->name('games');
Route::get('/games/{slug}', 'GameController@show')->name('game');

/**
 * Groups
 */
Route::get('/groups', 'GroupController@index')->name('groups');
Route::get('/groups/{slug}', 'GroupController@show')->name('group');

/**
 * Profiles
 */
Route::get('/profiles', 'ProfileController@index');
Route::get('/profiles/{id}', 'ProfileController@edit');
Route::post('/profiles', 'ProfileController@store');
Route::patch('/profiles/{id}',  ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
Route::delete('/profiles/{id}',  ['as' => 'profile.delete', 'uses' => 'ProfileController@destroy']);

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
    Route::get('/profiles/{id}', ['as' => 'settings.profile.edit', 'uses' => 'ProfileController@edit']);

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