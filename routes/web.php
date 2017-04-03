<?php
Route::get('/welcome', function () {
    return view('welcome');
})->name('home');

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
    'as' => 'account',
    'middleware' => 'auth'
]);

Route::post('/upateaccount', [
    'uses' => 'UserController@postSaveAccount',
    'as' => 'account.update',
    'middleware' => 'auth'
]);

Route::get('/userimage/{filename}', [
    'uses' => 'UserController@getUserImage',
    'as' => 'account.image',
    'middleware' => 'auth'
]);

Route::get('/', [
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

Route::get('/like/{post_id}', [
    'uses' => 'PostController@postLikePost',
    'as' => 'like',
    'middleware' => 'auth'
]);

Route::get('/unlike/{post_id}', [
    'uses' => 'PostController@postUnLikePost',
    'as' => 'unlike',
    'middleware' => 'auth'
]);

Route::get('/p/{username}', [
  'uses' => 'PostController@getProfile',
  'as' => 'profile',
  'middleware' => 'auth'
]);

Route::post('/addcomment', [
  'uses' => 'PostController@postAddComment',
  'as' => 'addcomment',
  'middleware' => 'auth'
]);

Route::post('/update-bio', [
    'uses' => 'UserController@postUpdateBio',
    'as' => 'update.bio',
    'middleware' => 'auth'
]);

Route::get('/post/{post_id}', [
    'uses' => 'PostController@getViewPost',
    'as' => 'view.post',
    'middleware' => 'auth'
]);

Route::get('/notif/{notif_id}', [
    'uses' => 'NotificationController@getReadNotification',
    'as' => 'read.notification',
    'middleware' => 'auth'
]);

// Friend Requests
Route::post('/send-friend-request', [
  'uses' => 'FriendController@postSendRequest',
  'as' => 'send.friend.request',
  'middleware' => 'auth'
]);
Route::post('/cancel-friend-request', [
    'uses' => 'FriendController@postCancelRequest',
    'as' => 'cancel.friend.request',
    'middleware' => 'auth'
]);
Route::get('/accept-friend-request/{frid}', [
    'uses' => 'FriendController@getAcceptRequest',
    'as' => 'accept.friend.request',
    'middleware' => 'auth'
]);
Route::get('/decline-friend-request/{frid}', [
    'uses' => 'FriendController@getDeclineRequest',
    'as' => 'decline.friend.request',
    'middleware' => 'auth'
]);

// Terms & Privacy
Route::get('/terms', function(){
    return view('terms');
})->name('terms');
Route::get('/privacy', function(){
    return view('privacy');
})->name('privacy');
