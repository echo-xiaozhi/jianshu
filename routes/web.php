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

Route::get('/', function () {
    return view('welcome');
});
// 用户模块
Route::get('/register', '\App\Http\Controllers\RegisterController@index');
Route::post('/register', '\App\Http\Controllers\RegisterController@register');
Route::get('/login', '\App\Http\Controllers\LoginController@index');
Route::post('/login', '\App\Http\Controllers\LoginController@login');
Route::get('/logout', '\App\Http\Controllers\LoginController@logout');
// 个人设置
Route::get('/user/me/setting', '\App\Http\Controllers\UserController@setting');

// 文章模块路由
Route::group(['prefix' => 'posts'], function () {
    // 查看文章列表
    Route::get('/', '\App\Http\Controllers\PostController@index');
    // 创建文章
    Route::get('/create', '\App\Http\Controllers\PostController@create');
    Route::post('/', '\App\Http\Controllers\PostController@store');
    // 查看文章详情
    Route::get('/{post}', '\App\Http\Controllers\PostController@show');
    // 编辑文章
    Route::get('/{post}/edit', '\App\Http\Controllers\PostController@edit');
    Route::put('/{post}', '\App\Http\Controllers\PostController@update');
    // 删除文章
    Route::get('/{post}/delete', '\App\Http\Controllers\PostController@delete');
    // 图片上传
    Route::post('/image/upload', '\App\Http\Controllers\PostController@imageUpload');
    // 创建评论
    Route::post('/{post}/comment', '\App\Http\Controllers\PostController@comment');
});
/*
 *  Route::any() any支持get post put delete options
 *  Route::match(['get, post']) match支持get post
 *  Route::group([], function() {})
 *  put表单传递方式
 *  <form action="" method="POST">
 *      <input type="hidden" name="_method" value="PUT" /> == {{ method_field('PUT') }}
 *  </form>
 *
 *  获取路由中的id
 *  function index($id)
 *  {
 *      return $id
 *  }
 *
 *  把模型绑定在路由中，然后去找到指定的方法
 *  Route::get('/posts/{post}', '\App\Http\Controllers\PostController@show');
 *  控制器中接收
 *  function show(\App\Post $post) {
 *      //······
 *  }
 */