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
})->middleware('guest')->name('welcome');

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
Route::get('/about', function() {
    return view('about');
});
Route::get('/contacts', function() {
    return view('contacts');
});
Route::get('/PitchDeck', function() {
    return view('pitchdeck');
});

Route::get('/news', 'NewsController@index')->name('news');
Route::get('/news/{slug}', 'NewsController@show')->name('news-post');

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
 * oAuth social
 */
Route::get('/social/{provider}', 'SocialController@login')->name('social.auth');
Route::get('/social/{provider}/callback', 'SocialController@callback');


Route::get('/feeds', ['uses' => 'HomeController@index', 'middleware' => 'auth'])->name('home');

/**
 * Users
 */
Route::group(['prefix' => 'users', 'middleware' => 'auth'], function () {
    Route::get('/{slug}', 'UserController@show')->name('user');
    Route::get('/{id}/feeds', 'UserController@feeds');
    Route::get('/{id}/wall', 'UserController@wall');
    Route::get('/{id}/groups', ['as' => 'user.groups', 'uses' => 'UserController@groups']);
    Route::get('/{id}/threads', ['as' => 'user.threads', 'uses' => 'UserController@threads']);
    Route::get('/{id}/profiles', 'UserController@apiProfiles');
    Route::patch('/',  ['as' => 'users.update', 'uses' => 'UserController@update']);
    Route::patch('/password',  ['as' => 'users.password.update', 'uses' => 'UserController@updatePassword']);
    Route::post('/{id}/threads', ['as' => 'user.threads.search', 'uses' => 'UserController@threads']);
    Route::post('/avatar', 'UserController@updateAvatar');
    Route::post('/overlay', 'UserController@updateOverlay');
});

Route::group(['prefix' => 'applications', 'middleware' => 'auth'], function () {
    Route::get('/', 'UserController@applications')->name('applications');
    Route::get('/{id}', 'ApplicationController@show')->name('application');
    Route::post('/', 'ApplicationController@store');
});

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
Route::group(['prefix' => 'groups', 'middleware' => 'auth'], function () {
    Route::get('/', ['as' => 'my.groups', 'uses' => 'UserController@myGroups']);
    Route::get('/search', 'GroupController@index')->name('groups');
    Route::get('/popular', 'GroupController@show')->name('groups.popular');
    Route::get('/{slug}', 'GroupController@show')->name('group');
    Route::get('/{id}/posts', 'GroupController@posts')->name('group.posts');
    Route::post('/{id}/checkin', 'GroupController@checkUserIsMember');
    Route::post('/{id}/users', 'GroupController@join');
    Route::post('/{id}/logo', 'GroupController@updateLogo');
    Route::post('/{id}/cover', 'GroupController@updateCover');
    Route::post('/', 'GroupController@store');
    //Route::get('/groups/{id}/users', 'GroupController@users')->name('group.users');
});

/**
 * Universities
 */
Route::group(['prefix' => 'universities', 'middleware' => 'auth'], function () {
    Route::get('/', 'UniversityController@groups')->name('universities');
    Route::get('/{slug}', 'GroupController@university')->name('university');
    Route::get('/{slug}/teams', 'GroupController@universityTeams');
    Route::post('/{id}/teams', ['uses' => 'UniversityController@teamsAdd']);
});

Route::get('/rest/universities', 'UniversityController@index');
Route::get('/rest/universities/{id}', 'UniversityController@show');
Route::get('/write-to-coach', ['uses' => 'UniversityController@groupsWithCoach', 'middleware' => 'auth'])->name('universities.write_to_coach');
Route::get('/apply-to-team', ['uses' => 'UniversityController@groupsApplyToTeam', 'middleware' => 'auth'])->name('universities.apply_to_team');
Route::patch('/teams/{id}', ['uses' => 'TeamController@update', 'middleware' => 'auth']);
Route::delete('/teams/{id}', ['uses' => 'TeamController@destroy', 'middleware' => 'auth']);

/**
 * Games
 */
Route::group(['prefix' => 'games', 'middleware' => 'auth'], function () {
    Route::get('/', 'GameController@groups')->name('games');
    Route::get('/{slug}', 'GroupController@game')->name('game');
});

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
    Route::get('/applications', ['as' => 'settings.applications', 'uses' => 'UserController@applications']);
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

Route::get('/helpers/link_preview', ['uses' => '\App\Acme\Helpers\LinkPreviewHelper@parse']);
Route::get('/y-combinator', ['uses' => 'HomeController@demoAuth']);
Route::get('/forcoaches', ['uses' => 'HomeController@demoAuth']);
Route::get('/forvcdemo', ['uses' => 'HomeController@demoAuth']);

Route::any('/404', function() {
    return View::make('errors.404', [], 404);
});


Route::group(['prefix' => 'api', 'middleware' => 'auth', 'namespace' => 'Api'], function () {

    Route::get('/search', [
        'as' => 'api.search',
        'uses' => 'SearchController@search'
    ]);

    Route::apiResource('games', 'GameController');
    Route::apiResource('groups', 'GroupController');
    Route::apiResource('users', 'UserController');

    /*Route::apiResource('channels', 'Api\ChannelController');
    Route::apiResource('comments', 'Api\CommentController');

    Route::apiResource('genres', 'Api\GenreController');        //done
    Route::apiResource('groups', 'Api\GroupController');
    Route::apiResource('likes', 'Api\LikeController');
    Route::apiResource('majors', 'Api\MajorController');
    Route::apiResource('medias', 'Api\MediaController');
    Route::apiResource('messages', 'Api\MessageController');
    Route::apiResource('posts', 'Api\PostController');
    Route::apiResource('profiles', 'Api\ProfileController');
    Route::apiResource('teams', 'Api\TeamController');
    Route::apiResource('tournaments', 'Api\TournamentController');
    Route::get('universities/filter', 'Api\UniversityController@filter');
    Route::apiResource('universities', 'Api\UniversityController');
    Route::apiResource('states', 'Api\StateController');        //done
    Route::apiResource('users', 'Api\UserController');*/
});
