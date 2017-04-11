<?php
// General Routes
Route::get('/welcome', function () {
    return view('welcome');
})->name('home');
Route::get('/', [
    'uses' => 'PostController@getDashboard',
    'as' => 'dashboard',
    'middleware' => 'auth'
]);
Route::get('/error', function(){
  return view('suspended');
})->name('suspended');
Route::get('/notif/{notif_id}', [
    'uses' => 'NotificationController@getReadNotification',
    'as' => 'read.notification',
    'middleware' => 'auth'
]);

// Post Routes
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
Route::post('/addcomment', [
    'uses' => 'PostController@postAddComment',
    'as' => 'addcomment',
    'middleware' => 'auth'
]);
Route::get('/post/{post_id}', [
    'uses' => 'PostController@getViewPost',
    'as' => 'view.post',
    'middleware' => 'auth'
]);

// Report Routes
Route::post('/report/{post_id}', [
    'uses' => 'ReportController@postAddReport',
    'as' => 'send-report',
    'middleware' => 'auth'
]);
Route::post('/admin/report/{report_id}', [
    'uses' => 'ReportController@postReportAdmin',
    'as' => 'report.update',
    'middleware' => 'auth'
]);

// User Routes
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
Route::post('/update-info/account', [
    'uses' => 'UserController@postUpdateAccount',
    'as' => 'account.update',
    'middleware' => 'auth'
]);
Route::get('/userimage/{filename}', [
    'uses' => 'UserController@getUserImage',
    'as' => 'account.image',
    'middleware' => 'auth'
]);
Route::get('/p/{username}', [
    'uses' => 'PostController@getProfile',
    'as' => 'profile',
    'middleware' => 'auth'
]);
Route::post('/update-info/bio', [
    'uses' => 'UserController@postUpdateBio',
    'as' => 'update.bio',
    'middleware' => 'auth'
]);

// Friend Requests Routes
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

// Terms & Privacy Routes
Route::get('/terms', function(){
    return view('terms');
})->name('terms');
Route::get('/privacy', function(){
    return view('privacy');
})->name('privacy');

// Admin Routes
Route::get('/admin', [
  'uses' => 'AdminController@getDashboard',
  'as' => 'admin.dashboard',
  'middleware' => 'auth'
]);
Route::get('/admin/users', [
  'uses' => 'AdminController@getUsers',
  'as' => 'admin.users',
  'middleware' => 'auth'
]);
Route::get('/admin/posts', [
  'uses' => 'AdminController@getPosts',
  'as' => 'admin.posts',
  'middleware' => 'auth'
]);
Route::get('/admin/comments', [
    'uses' => 'AdminController@getComments',
    'as' => 'admin.comments',
    'middleware' => 'auth'
]);
Route::get('/admin/reports', [
    'uses' => 'AdminController@getReports',
    'as' => 'admin.reports',
    'middleware' => 'auth'
]);
Route::get('admin/user/{user_id}', [
    'uses' => 'AdminController@getUser',
    'as' => 'admin.user',
    'middleware' => 'auth'
]);
Route::get('admin/post/{post_id}', [
    'uses' => 'AdminController@getPost',
    'as' => 'admin.post',
    'middleware' => 'auth'
]);
Route::get('/admin/comment/{comment_id}', [
    'uses' => 'AdminController@getComment',
    'as' => 'admin.comment',
    'middleware' => 'auth'
]);
Route::get('/admin/report/{report_id}', [
    'uses' => 'AdminController@getReport',
    'as' => 'admin.report',
    'middleware' => 'auth'
]);

// Email Sending
Route::get('/send', [
    'uses' => 'UserController@send'
]);