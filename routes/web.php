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

//ログイン
Auth::routes();

//Googleログイン
Route::prefix('login')->name('login.')->group(function () {
    Route::get('/{provider}', 'Auth\LoginController@redirectToProvider')->name('{provider}');
    Route::get('/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('{provider}.callback');
});

//Google会員登録
Route::prefix('register')->name('register.')->group(function () {
    Route::get('/{provider}', 'Auth\RegisterController@showProviderUserRegistrationForm')->name('{provider}');
    Route::post('/{provider}', 'Auth\RegisterController@registerProviderUser')->name('{provider}');
});

//未ログイントップページ
Route::get('/', 'ReviewController@index')->name('reviews.index');

//ログイン済みアカウントのみ閲覧可能
Route::middleware('auth')->group(function () {
    //ログイン済みトップページ    
    Route::resource('/reviews', 'ReviewController')->except(['index'])->middleware('auth');
    
    //記事詳細画面
    Route::resource('/reviews', 'ReviewController')->only(['show']);
    
    //いいねボタン
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::put('/{review}/like', 'ReviewController@like')->name('like');
        Route::delete('/{review}/like', 'ReviewController@unlike')->name('unlike');
    });
    
    Route::prefix('users')->name('users.')->group(function () {
    //ユーザ編集画面
    Route::get('/edit', 'UsersController@edit');
    
    //ユーザ更新画面
    Route::post('/update', 'UsersController@update');
    
    //ユーザ詳細画面
    Route::get('/{user_id}', 'UsersController@show')->name('show');
    //いいねした記事一覧
    Route::get('/{user_id}/likes', 'UsersController@likes')->name('likes');
    
    //フォローしているアカウント一覧
    Route::get('/{user_id}/followings', 'UsersController@followings')->name('followings');
    //フォローされているアカウント一覧
    Route::get('/{user_id}/followers', 'UsersController@followers')->name('followers');
    
    //フォローをする・フォローを外す
    Route::put('/{user_id}/follow', 'UsersController@follow')->name('follow');
    Route::delete('/{user_id}/follow', 'UsersController@unfollow')->name('unfollow');
    
    });
});
