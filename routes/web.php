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

Route::get('/',  function() {
    return view('welcome');
})->middleware('guest');

Route::get('/feeds', ['uses' => 'HomeController@index', 'middleware' => 'auth'])->name('home');
Route::get('/terms', function() {
    return view('terms');
})->name('terms');
Route::get('/legal/confidential', function() {
    return view('policy');
});
Route::get('/cookies-policy', function() {
    return view('cookies_policy');
});

Route::get('/legal/term-and-conditions', function() {
    return view('terms_and_conditions');
});
Route::get('/legal/term-of-service', function() {
    return view('term_of_service');
});

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
Route::get('/register-coach', ['uses' => 'Auth\RegisterController@showRegistrationCoachForm', 'middleware' => 'guest'])->name('register_coach');
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
 * Groups
 */
Route::get('/groups', ['as' => 'my.groups', 'uses' => 'UserController@myGroups', 'middleware' => 'auth']);
Route::get('/groups/search', 'GroupController@index')->name('groups');
Route::get('/groups/popular', 'GroupController@show')->name('groups.popular');
Route::get('/groups/{slug}', 'GroupController@show')->name('group');
Route::get('/groups/{id}/posts', 'GroupController@posts')->name('group.posts');
Route::post('/groups/{id}/checkin', 'GroupController@checkUserIsMember');
Route::post('/groups/{id}/users', 'GroupController@join');
Route::post('/groups/{id}/logo', 'GroupController@updateLogo');
Route::post('/groups/{id}/cover', 'GroupController@updateCover');
//Route::get('/groups/{id}/users', 'GroupController@users')->name('group.users');


/**
 * Universities
 */
Route::get('/rest/universities', 'UniversityController@index');
Route::get('/rest/universities/{id}', 'UniversityController@show');
Route::get('/universities', 'UniversityController@groups')->name('universities');
Route::get('/universities/{slug}', 'GroupController@university')->name('university');
Route::get('/write-to-coach', 'UniversityController@groupsWithCoach')->name('universities.write_to_coach');
Route::get('/apply-to-team', 'UniversityController@groupsApplyToTeam')->name('universities.apply_to_team');
Route::get('/universities/{slug}/teams', 'GroupController@universityTeams');
Route::post('/universities/{id}/teams', ['uses' => 'UniversityController@teamsAdd', 'middleware' => 'auth']);
Route::patch('/teams/{id}', ['uses' => 'TeamController@update', 'middleware' => 'auth']);
Route::delete('/teams/{id}', ['uses' => 'TeamController@destroy', 'middleware' => 'auth']);

/**
 * Games
 */
Route::get('/games', 'GameController@groups')->name('games');
Route::get('/games/{slug}', 'GroupController@game')->name('game');
Route::get('/rest/games', 'GameController@index');
Route::get('/rest/games/{id}', 'GameController@show');

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
 * Countries
 */
Route::resource('countries','CountryController');
Route::get('/countries/{slug}/states', 'CountryController@states');

/**
 * Upload
 */
Route::post('/upload', 'UploadController@store');
Route::delete('/upload', 'UploadController@delete');

/**
 * Majors
 */
Route::resource('majors','MajorController');

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
    Route::get('/profiles/add', ['as' => 'settings.profile.add', 'uses' => 'ProfileController@create']);
    Route::get('/profiles/{id}/edit', ['as' => 'settings.profile.edit', 'uses' => 'ProfileController@edit']);
});

/**
 * Friends
 */
Route::group(['prefix' => 'friends', 'middleware' => 'auth'], function () {
    Route::get('/', ['as' => 'friends', 'uses' => 'FriendController@index']);
    Route::get('/possible', ['as' => 'friends.possible', 'uses' => 'FriendController@possible']);
    Route::get('/find', ['as' => 'friends.find', 'uses' => 'FriendController@find']);
    Route::get('/requests/in', ['as' => 'friends.requests.in', 'uses' => 'FriendController@requestsIn']);
    Route::get('/requests/out', ['as' => 'friends.requests.out', 'uses' => 'FriendController@requestsOut']);
});

/**
 * Friendships
 */
Route::group(['prefix' => 'friendships', 'middleware' => 'auth'], function () {
    Route::delete('/{id}', 'FriendshipController@destroy');
});

/**
 * Me
 */
Route::group(['prefix' => 'me', 'middleware' => 'auth'], function () {
    Route::get('/friends', ['uses' => 'UserController@friends']);
    Route::get('/possibleFriends', ['uses' => 'UserController@possibleFriends']);
    Route::get('/friendRequestsIn', ['uses' => 'UserController@friendRequestsIn']);
    Route::get('/friendRequestsOut', ['uses' => 'UserController@friendRequestsOut']);
    Route::post('/addFriend', ['uses' => 'UserController@befriend']);
    Route::post('/unfriend', ['uses' => 'UserController@unfriend']);
    Route::post('/acceptFriend', ['uses' => 'UserController@acceptFriendRequest']);
    Route::post('/denyFriend', ['uses' => 'UserController@denyFriendRequest']);
});

Route::get('404', ['as' => '404', 'uses' => 'ErrorController@notfound']);
Route::get('500', ['as' => '500', 'uses' => 'ErrorController@fatal']);

Route::get('/helpers/link_preview', ['uses' => '\App\Acme\Helpers\LinkPreviewHelper@parse']);
