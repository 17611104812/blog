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

Route::get('/',function(){
   return redirect('/login');
});

Route::group(['middleware'=>'auth:web'],function(){

    //文章列表页
    Route::get('/posts','PostController@index');

//新建文章
    Route::get('/posts/create','PostController@create');
    Route::post('/posts','PostController@store');

//编辑文章
    Route::get('/posts/{post}/edit','PostController@edit');
    Route::post('/posts/{post}','PostController@update');

//文章详情页
    Route::get('/posts/{post}','PostController@show');

//删除文章
    Route::get('/posts/{post}/delete','PostController@delete');


    Route::post('/posts/image/upload','PostController@imageUpload');

    Route::get('/logout','LoginController@logout');

    Route::get('/setting/user','UserController@setting');
    Route::post('/setting/user','UserController@settingStore');

    Route::post('/posts/{post}/comment','PostController@comment');


    Route::get('/posts/{post}/zan','PostController@zan');
    Route::get('/posts/{post}/unzan','PostController@unzan');

});





Route::get('/register','RegisterController@register');
Route::post('/register','RegisterController@registerStore');

Route::get('/login','LoginController@login')->name('login');
Route::post('/login','LoginController@loginStore');





