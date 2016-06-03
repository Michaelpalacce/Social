<?php


Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('/signup',[
    'uses'=>'UserController@postSignUp',
    'as'=>'signup'
]);

Route::post('/signin',[
    'uses'=>'UserController@postSignIn',
    'as'=>'signin'
]);

Route::get('/logout',[
    'uses'=>'UserController@getLogout',
    'as'=>'logout'
]);


Route::get('/dashboard',[
    'uses'=>'PostController@getDashboard',
    'as'=>'dashboard',
    'middleware'=>'auth'
]);



Route::post('/createpost',[
    'uses'=>'PostController@postCreatePost',
    'as'=>'post.create',
    'middleware'=>'auth'
]);

Route::get('/deletepost/{post_id}',[
    'uses'=>'PostController@getDeletePost',
    'as'=>'post.delete',
    'middleware'=>'auth'
]);

Route::POST('/edit',[
    'uses'=>'PostController@postEditPost',
    'as'=>'edit',
    'middleware'=>'auth'
]);

Route::get('/account',[
    'uses'=>'UserController@getAccount',
    'as'=>'account',
    'middleware'=>'auth'
]);

Route::post('/updateaccount',[
    'uses'=>'UserController@postSaveAccount',
    'as'=>'account.save',
    'middleware'=>'auth'
]);

Route::get('/userimage/{filename}',[
    'uses'=>'UserController@getUserImage',
    'as'=>'account.image',
    'middleware'=>'auth'
]);

Route::POST('/like',[
    'uses'=>'PostController@postLikePost',
    'as'=>'like'
]);