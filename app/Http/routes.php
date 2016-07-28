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




Route::get('/', [
    'uses' => 'UserController@getHome',
    'as' => 'home',
//    'middleware' => 'guest'
]);

Route::post('/signup', [
    'uses' => 'UserController@postSignUp',
    'as' => 'signup'
]);

Route::post('/signin', [
    'uses' => 'UserController@postSignIn',
    'as' => 'signin'
]);

Route::get('/logout', [
    'uses' => 'UserController@getLogout',
    'as' => 'logout'
]);

Route::get('/account', [
    'uses' => 'UserController@getAccount',
    'as' => 'account'
]);

Route::post('/updateaccount', [
    'uses' => 'UserController@postSaveAccount',
    'as' => 'account.save'
]);

Route::get('/userimage/{filename}', [
    'uses' => 'UserController@getUserImage',
    'as' => 'account.image'
]);

Route::get('/notifications', [
    'uses' => 'UserController@getUpdates',
    'as' => 'zone.updates',
    'middleware' => 'auth'
]);

Route::get('/dashboard', [
    'uses' => 'PostController@getDashboard',
    'as' => 'dashboard',
    'middleware' => 'auth'
]);

Route::post('/createpost', [
    'uses' => 'PostController@postCreatePost',
    'as' => 'post.create',
    'middleware' => 'auth'
]);

Route::get('/delete-post/{post_id}', [
    'uses' => 'PostController@getDeletePost',
    'as' => 'post.delete',
    'middleware' => 'auth'
]);

Route::post('/edit', [
    'uses' => 'PostController@postEditPost',
    'as' => 'edit',
    'middleware' => 'auth'
]);

Route::post('/like', [
    'uses' => 'PostController@postLikePost',
    'as' => 'like',
    'middleware' => 'auth'
]);

Route::post('/dislike', [
    'uses' => 'PostController@postDislikePost',
    'as' => 'dislike',
    'middleware' => 'auth'
]);

Route::get('/user-profile/{user_id?}',[
    'uses' => 'UserController@getUserProfile',
    'as' => 'user-profile',
    'middleware' => 'auth'
]);

Route::post('/accept-request', [
    'uses' => 'UserController@postAcceptRequest',
    'as' => 'accept.request',
    'middleware' => 'auth'
]);

Route::post('/send-friend-request', [
    'uses' => 'UserController@postFriendRequest',
    'as' => 'friend.request',
    'middleware' => 'auth'
]);


Route::post('/remove-friend', [
    'uses' => 'UserController@postRemoveFriend',
    'as' => 'remove.friend',
    'middleware' => 'auth'
]);

Route::post('/cancel-friend-request', [
    'uses' => 'UserController@postCancelRequest',
    'as' => 'cancel.request',
    'middleware' => 'auth'
]);

Route::post('/delete-friend-request', [
    'uses' => 'UserController@postDeleteRequest',
    'as' => 'delete.request',
    'middleware' => 'auth'
]);

Route::post('/add-comment', [
    'uses' => 'CommentController@postAddComment',
    'as' => 'add.comment',
    'middleware' => 'auth'
]);

Route::post('/add-delete', [
    'uses' => 'CommentController@postDeleteComment',
    'as' => 'delete.comment',
    'middleware' => 'auth'
]);

