<?php
// General
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
Route::get('/terms', function(){
    return view('terms');
})->name('terms');

Route::group(['middleware' => 'auth'], function () {
    // General
    Route::get('/', [
        'uses' => 'PostController@getDashboard',
        'as' => 'dashboard'
    ]);
    Route::get('/notif/{notif_id}', [
        'uses' => 'NotificationController@getReadNotification',
        'as' => 'read.notification'
    ]);

    // Posts
    Route::post('/createpost', [
        'uses' => 'PostController@postCreatePost',
        'as' => 'post.create'
    ]);
    Route::get('/delete-post/{post_id}', [
        'uses' => 'PostController@getDeletePost',
        'as' => 'post.delete'
    ]);
    Route::post('/edit', [
        'uses' => 'PostController@postEditPost',
        'as' => 'edit'
    ]);
    Route::get('/like/{post_id}', [
        'uses' => 'PostController@postLikePost',
        'as' => 'like'
    ]);
    Route::get('/unlike/{post_id}', [
        'uses' => 'PostController@postUnLikePost',
        'as' => 'unlike'
    ]);
    Route::post('/addcomment', [
        'uses' => 'PostController@postAddComment',
        'as' => 'addcomment'
    ]);
    Route::get('/post/{post_id}', [
        'uses' => 'PostController@getViewPost',
        'as' => 'view.post'
    ]);

    // Reports
    Route::post('/report/{post_id}', [
        'uses' => 'ReportController@postAddReport',
        'as' => 'send-report'
    ]);
    Route::post('/admin/report/{report_id}', [
        'uses' => 'ReportController@postReportAdmin',
        'as' => 'report.update'
    ]);

    // User
    Route::get('/account', [
        'uses' => 'UserController@getAccount',
        'as' => 'account'
    ]);
    Route::post('/update-info/account', [
        'uses' => 'UserController@postUpdateAccount',
        'as' => 'account.update'
    ]);
    Route::get('/userimage/{filename}', [
        'uses' => 'UserController@getUserImage',
        'as' => 'account.image'
    ]);
    Route::get('/p/{username}', [
        'uses' => 'PostController@getProfile',
        'as' => 'profile'
    ]);
    Route::post('/update-info/bio', [
        'uses' => 'UserController@postUpdateBio',
        'as' => 'update.bio'
    ]);

    // Friend Requests
    Route::post('/send-friend-request', [
        'uses' => 'FriendController@postSendRequest',
        'as' => 'send.friend.request'
    ]);
    Route::post('/cancel-friend-request', [
        'uses' => 'FriendController@postCancelRequest',
        'as' => 'cancel.friend.request'
    ]);
    Route::get('/accept-friend-request/{frid}', [
        'uses' => 'FriendController@getAcceptRequest',
        'as' => 'accept.friend.request'
    ]);
    Route::get('/decline-friend-request/{frid}', [
        'uses' => 'FriendController@getDeclineRequest',
        'as' => 'decline.friend.request'
    ]);

    // Admin
    Route::group(['prefix' => 'admin'], function(){
        Route::get('/users', [
            'uses' => 'AdminController@getUsers',
            'as' => 'admin.users'
        ]);
        Route::get('/posts/{user_id?}', [
            'uses' => 'AdminController@getPosts',
            'as' => 'admin.posts'
        ]);
        Route::get('/comments/{user_id?}', [
            'uses' => 'AdminController@getComments',
            'as' => 'admin.comments'
        ]);
        Route::get('/reports/{user_id?}', [
            'uses' => 'AdminController@getReports',
            'as' => 'admin.reports'
        ]);
        Route::get('/user/{user_id}', [
            'uses' => 'AdminController@getUser',
            'as' => 'admin.user'
        ]);
        Route::get('/post/{post_id}', [
            'uses' => 'AdminController@getPost',
            'as' => 'admin.post'
        ]);
        Route::get('/comment/{comment_id}', [
            'uses' => 'AdminController@getComment',
            'as' => 'admin.comment'
        ]);
        Route::get('/report/{report_id}', [
            'uses' => 'AdminController@getReport',
            'as' => 'admin.report'
        ]);
        Route::post('/user/{user_id}/a-update', [
            'uses' => 'AdminController@postUpdateUserA',
            'as' => 'admin.update.user'
        ]);
        Route::post('/user/{user_id}/a-update/bio', [
            'uses' => 'AdminController@postUpdateUserBio',
            'as' => 'admin.update.user.bio'
        ]);
        Route::post('/user/{user_id}/sa-update', [
            'uses' => 'AdminController@postUpdateUserSA',
            'as' => 'super.admin.update.user'
        ]);
        Route::get('/comment/{comment_id}/delete', [
            'uses' => 'AdminController@getDeleteComment',
            'as' => 'admin.comment.delete'
        ]);
    });
    Route::get('/admin', [
        'uses' => 'AdminController@getDashboard',
        'as' => 'admin.dashboard'
    ]);

    // Messages
    Route::group(['prefix' => 'messages'], function(){
        Route::get('/', [
            'uses' => 'MessagesController@getIndex',
            'as' => 'messages.index'
        ]);
        Route::get('/new/{username?}', [
            'uses' => 'MessagesController@getNewChat',
            'as' => 'messages.new.chat'
        ]);
        Route::post('/new/send', [
            'uses' => 'MessagesController@postNewChat',
            'as' => 'messages.new.chat.post'
        ]);
        Route::group(['prefix' => 'chat'], function(){
            Route::get('/{chat_id}', [
                'uses' => 'MessagesController@getChat',
                'as' => 'messages.get.chat'
            ]);
            Route::post('/{chat_id}/send', [
                'uses' => 'MessagesController@postSendChat',
                'as' => 'messages.chat.send'
            ]);
        });
    });
});

// Email Sending
Route::get('/send', [
    'uses' => 'UserController@send'
]);