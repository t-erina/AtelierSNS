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

Route::group(['middleware' => ['guest']], function () {
  Route::namespace('auth')->group(function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login');
    Route::view('/register-form', 'auth.register')->name('registerForm');
    Route::post('/register', 'RegisterController@register')->name('register');
  });
});

Route::group(['middleware' => ['auth']], function () {
  Route::get('/logout', 'auth\LogoutController@logout')->name('logout');

  Route::namespace('posts')->group(function () {
    Route::get('/top', 'PostsController@index')->name('top');
    Route::get('/post/store-form', 'PostsController@showPostForm')->name('postForm');
    Route::post('post/store', 'PostsController@store')->name('storePost');
    Route::get('/post/update-form/{post_id}', 'PostsController@postUpdateForm')->name('postUpdateForm');
    Route::post('post/update', 'PostsController@update')->name('updatePost');
    Route::get('/post/detail/{post_id}', 'PostsController@showDetail')->name('postDetail');
    Route::post('/post/delete/{post_id}', 'PostsController@delete')->name('deletePost');
    Route::post('comment/store/{post_id}','PostCommentsController@store' )->name('storeComment');
    Route::post('comment/update/{comment_id}', 'PostCommentsController@update')->name('updateComment');
    Route::post('comment/delete/{comment_id}', 'PostCommentsController@delete')->name('deleteComment');
    Route::post('like/store/{post_id}', 'LikesController@store')->name('storeLike');
    Route::post('like/delete/{post_id}', 'LikesController@delete')->name('deleteLike');
  });

  Route::namespace('users')->group(function () {
    Route::get('/profile/show/{user_id}', 'UsersController@index')->name('profile');
    Route::get('/profile/edit-form', 'UsersController@profileEditForm')->name('profileEditForm');
    Route::post('/profile/update', 'UsersController@updateProfile')->name('updateProfile');
    Route::view('/user/edit-form', 'users.user_edit-form.user_edit-list')->name('userEditForm');
    Route::view('/user/edit-form/username', 'users.user_edit-form.username-form')->name('usernameUpdateForm');
    Route::view('/user/edit-form/email', 'users.user_edit-form.email-form')->name('emailUpdateForm');
    Route::view('/user/edit-form/password', 'users.user_edit-form.password-form')->name('passwordUpdateForm');
    Route::post('/user/update/username', 'UserUpdateController@updateUsername')->name('updateUsername');
    Route::post('/user/update/email', 'UserUpdateController@updateEmail')->name('updateEmail');
    Route::post('/user/update/password', 'UserUpdateController@updatePassword')->name('updatePassword');
  });

  Route::namespace('follows')->group(function(){
    Route::post('/store-follow/{user_id}', 'FollowsController@store')->name('storeFollow');
    Route::post('/delete-follow/{user_id}', 'FollowsController@delete')->name('deleteFollow');
  });

  Route::namespace('search')->group(function () {
    Route::post('/search', 'SearchController@index')->name('searchResult');
  });
});
