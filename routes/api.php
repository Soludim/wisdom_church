<?php

use App\Http\Middleware\CheckRole;
use App\Http\Controllers\Api\LoginController;
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

Route::resource('role', 'Api\RoleController');

Route::get('index', 'Api\IndexController@index');
Route::get('about', 'Api\IndexController@about');
Route::middleware('auth:api')->get('/dash_index', 'Api\IndexController@dashboard');


Route::get('/user/{id}', 'Api\UserController@show');
Route::get('user', 'Api\UserController@index');
Route::post('user', 'Api\UserController@register');
Route::post('login', 'Api\UserController@login');
Route::middleware('auth:api')->post('profile', 'Api\UserController@update');
Route::middleware('auth:api')->put('passwordreset', 'Api\UserController@changePassword');
Route::middleware(['auth:api', CheckRole::class])->post('/user/role', 'Api\UserController@update_role');

Route::post('sendmail', 'Api\ContactController@sendMail');

Route::resource('prayerrequest', 'Api\PrayerRequestController', ['except' => ['create']]);
Route::resource('testimony', 'Api\TestimonyController', ['except' => ['create', 'update']]);

Route::middleware(['auth:api', CheckRole::class])->post('sermon/{id}', 'Api\SermonController@update_sermon');
Route::resource('sermon', 'Api\SermonController', ['except' => ['create', 'update']]);
Route::get('sermon_single/{id}', 'Api\SermonController@sermon_single');
Route::get('/speakers', 'Api\SermonController@speakerQueryResult');  //selecting preachers for sermon


Route::middleware('auth:api')->post('post/{id}', 'Api\PostController@update_post');
Route::resource('post', 'Api\PostController', ['except' => ['create', 'update']]);
Route::get('user/{id}/post', 'Api\PostController@user_posts');
Route::get('category', 'Api\PostController@categories');
Route::get('category/post', 'Api\PostController@category_posts');
Route::get('blog_single/{id}', 'Api\PostController@blog_single');



Route::middleware(['auth:api', CheckRole::class])->post('event/{id}', 'Api\EventController@update_event');
Route::resource('event', 'Api\EventController', ['except' => ['create', 'update']]);



Route::get('chat/{id}/user', 'Api\ChatUserController@index'); //get all users of a particaular chat
Route::get('user_chat/{id}', 'Api\ChatUserController@myChats');   //get user chats
Route::middleware('auth:api')->post('chat/user', 'Api\ChatUserController@store');
Route::middleware('auth:api')->post('chat_user', 'Api\ChatUserController@addOrRemove'); //add or remove user from chat
Route::middleware('auth:api')->delete('chat/{id}/user', 'Api\ChatUserController@remove');



Route::get('chat/{id}/msg', 'Api\ChatMsgController@index');
Route::middleware('auth:api')->post('chat_msg', 'Api\ChatMsgController@store');
Route::middleware('auth:api')->delete('chat_msg/{id}', 'Api\ChatMsgController@remove');

Route::resource('chat', 'Api\ChatController', ['except' => ['create']]);


Route::middleware('auth:api')->post('comment', 'Api\CommentController@store');  //create comment
Route::get('post/{id}/comment', 'Api\CommentController@post_comments'); //get all comments for specified post
Route::middleware('auth:api')->put('comment/{id}', 'Api\CommentController@edit_comment');  //update comment
Route::middleware('auth:api')->delete('comment/{id}', 'Api\CommentController@del_comment'); //delete comment
Route::get('sermon/{id}/comment', 'Api\CommentController@sermon_comments'); //get all comments for specified sermon


Route::middleware('auth:api')->post('reply', 'Api\ReplyController@store');  //create reply
Route::get('comment/{id}/reply', 'Api\ReplyController@comment_replies'); //get all replies for specified comment
Route::middleware('auth:api')->put('reply/{id}', 'Api\ReplyController@update_reply'); //update reply of a specified comment
Route::middleware('auth:api')->delete('reply/{id}', 'Api\ReplyController@delete_reply'); //delete reply of a specified comment


Route::middleware('auth:api')->post('like', 'Api\LikeController@like');  //like something
Route::get('comment/{id}/like', 'Api\LikeController@comment_likes'); //get all likes for a specified comment
Route::get('reply/{id}/like', 'Api\LikeController@reply_likes'); //get all likes for a specified reply


