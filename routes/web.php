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
Route::get('/users/{slug}', 'UserController@show')->name('user');
Route::get('/users/{id}/feeds', 'UserController@feeds');
Route::get('/users/{id}/wall', 'UserController@wall');
Route::get('/users/{id}/groups', ['as' => 'user.groups', 'uses' => 'UserController@groups']);
Route::get('/users/{id}/threads', ['as' => 'user.threads', 'uses' => 'UserController@threads']);
Route::post('/users/{id}/threads', ['as' => 'user.threads.search', 'uses' => 'UserController@threads']);
Route::post('/users/avatar', 'UserController@updateAvatar');
Route::post('/users/overlay', 'UserController@updateOverlay');


/**
 * Messages
 */
/*Route::group(['prefix' => 'im', 'middleware' => 'auth'], function () {
    Route::get('/', ['as' => 'messages', 'uses' => 'MessageController@index']);
    Route::get('create', ['as' => 'messages.create', 'uses' => 'MessageController@create']);
    Route::post('/', ['as' => 'messages.store', 'uses' => 'MessageController@store']);
    Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessageController@show']);
    Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessageController@update']);
});*/

/**
 * Channels
 */
Route::get('/im', ['as' => 'im', 'uses' => 'ThreadController@index']);
Route::group(['prefix' => 'channels', 'middleware' => 'auth'], function () {
    Route::get('/', ['as' => 'channels.list', 'uses' => 'ThreadController@index']);
    Route::post('/', ['as' => 'channels.store', 'uses' => 'ThreadController@store']);
    Route::get('/{channel_id}/participants', ['as' => 'channels.participants', 'uses' => 'ThreadController@participants']);
    Route::get('/{channel_id}/messages', ['as' => 'channels.messages', 'uses' => 'ThreadController@messages']);
    Route::post('/{channel_id}/messages', ['as' => 'channels.messages.store', 'uses' => 'ThreadController@messageStore']);
});

/**
 * Games
 */
Route::get('/games', 'GameController@index')->name('games');
Route::get('/games/{slug}', 'GameController@show')->name('game');

/**
 * Groups
 */
Route::get('/groups', ['as' => 'my.groups', 'uses' => 'UserController@myGroups', 'middleware' => 'auth']);
Route::get('/groups/search', 'GroupController@index')->name('groups');
Route::get('/groups/popular', 'GroupController@show')->name('groups.popular');
Route::get('/groups/{slug}', 'GroupController@show')->name('group');
Route::get('/groups/{id}/posts', 'GroupController@posts')->name('group.posts');
Route::post('/groups/{id}/checkin', 'GroupController@checkUserIsMember');
Route::post('/groups/{id}/users', 'GroupController@join');
//Route::get('/groups/{id}/users', 'GroupController@users')->name('group.users');


/**
 * Groups
 */
Route::get('/universities', 'GroupController@universities')->name('universities');
Route::get('/universities/{slug}', 'GroupController@university')->name('university');

/**
 * Profiles
 */
Route::get('/profiles', 'ProfileController@index');
Route::get('/profiles/{id}', 'ProfileController@edit');
Route::post('/profiles', 'ProfileController@store');
Route::patch('/profiles/{id}', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
Route::delete('/profiles/{id}', ['as' => 'profile.delete', 'uses' => 'ProfileController@destroy']);

/**
 * Posts
 */
Route::resource('posts','PostController');

/**
 * Comments
 */
Route::resource('comments','CommentController');

/**
 * Likes
 */
Route::resource('likes','LikeController');

/**
 * Upload
 */
Route::post('/upload', 'UploadController@store');
Route::delete('/upload', 'UploadController@delete');

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
});