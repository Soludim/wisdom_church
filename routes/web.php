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

use App\Events\ChatEvent;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\Auth\LoginController;

Route::Auth();
Route::get('login/{provider}', [LoginController::class, 'redirectToProvider']);
Route::get('login/{provider}/callback', [LoginController::class, 'handleProviderCallback']);


/////////////User Controller routes
Route::middleware('auth')->get('/dashboard', 'DashboardController@index');
Route::middleware(['auth', CheckRole::class])->get('/members/{page?}', 'UserController@members')->name('members'); //get all members
Route::middleware('auth')->resource('/profile', 'UserController')->only(['index', 'update']);   //view user dashboard profile
Route::middleware('auth')->put('/passwordreset', 'UserController@change_password')->name('passwordreset');
Route::middleware(['auth', CheckRole::class])->post('/user/role', 'UserController@update_role');  //update user role

Route::resource('contact', 'ContactController')->only(['index', 'store']);  //contact page to compose and send email


/////////////////////Post Controller routes
Route::middleware('auth')->get('/posts/{page?}', 'PostController@myposts')->name('posts');
Route::middleware(['auth', CheckRole::class])->get('/allposts/{page?}', 'PostController@allposts')->name('allposts');
Route::get('/blog/{page?}', 'PostController@index')->name('blog');
Route::middleware('auth')->get('/post/{id}/details', 'PostController@details');
Route::resource('/post', 'PostController', ['except' => 'index']);


////////////////////Prayer Request Controller routes
Route::middleware(['auth', CheckRole::class])->get('/prayerrequest/{page?}', 'PrayerRequestController@index')->name('prayerrequest');
Route::post('/prayerrequest', 'PrayerRequestController@store')->name('prayer_store');
Route::middleware(['auth', CheckRole::class])->resource('/prayerrequest', 'PrayerRequestController', ['except' => ['index', 'store', 'edit']]);


/////////////////////Testimony Controller routes
Route::middleware(['auth', CheckRole::class])->get('/testimonies/{page?}', 'TestimonyController@index')->name('testimony');
Route::middleware('auth')->resource('testimonies', 'TestimonyController', ['only' => ['store', 'destroy']]);



//////////////////////Event Controller routes
Route::middleware(['auth', CheckRole::class])->get('/devents/{page?}', 'EventController@dindex')->name('devents');
Route::get('/events/{page?}', 'EventController@index')->name('events');
Route::get('/event/{id}', 'EventController@show');         //show a single event
Route::middleware(['auth', CheckRole::class])->resource('/devent', 'EventController', ['except' => ['index', 'show']]);
Route::middleware(['auth', CheckRole::class])->get('/event/{id}/details', 'EventController@details');


////////////////Comment Controller routes
Route::middleware('auth')->resource('/comment', 'CommentController', ['only' => ['store', 'destroy']]);




///////////////Reply Controller routes
Route::middleware('auth')->resource('/reply', 'ReplyController', ['only' => ['store', 'destroy']]);



///////////////////////Sermon Controller routes
Route::get('sermons/{page?}', 'SermonController@index')->name('sermons');
Route::middleware(['auth', CheckRole::class])->get('dsermons/{page?}', 'SermonController@dindex')->name('dsermons');
Route::middleware(['auth', CheckRole::class])->get('/dsermon/{id}/details', 'SermonController@details');
Route::get('sermon/{id}', 'SermonController@show');
Route::middleware(['auth', CheckRole::class])->resource('dsermon', 'SermonController', ['except' => ['index', 'show']]);



//////////////////////////Chat Controller routes
Route::middleware('auth')->resource('chat', 'ChatController', ['except' => ['create', 'edit']]);
Route::middleware('auth')->post('chat_room', 'ChatController@postMsg');  //sending a message to a chat
Route::middleware('auth')->get('/chat_room/{id}', 'ChatController@chatRoom');  //chat_room contoller


//////////////////////Index Contoller routes
Route::get('/about', 'IndexController@about');           //about page
Route::get('/', 'IndexController@index')->name('home');  //home Page of the site
