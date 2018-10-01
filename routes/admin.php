<?php
Route::group(['prefix' => '/admin'], function (){
    // 登录页面
    Route::get('/login', '\App\Admin\Controllers\LoginController@index')->name('login');
    // 登录行为
    Route::post('/login', '\App\Admin\Controllers\LoginController@login');
    // 登出
    Route::get('/logout', '\App\Admin\Controllers\LoginController@logout');
    // 后台验证
    Route::group(['middleware' => 'auth:admin'], function () {
        // 后台首页
        Route::get('/home', '\App\Admin\Controllers\HomeController@index');
        // 用户管理模块
        Route::get('/users', '\App\Admin\Controllers\UserController@index');
        Route::get('/users/create', '\App\Admin\Controllers\UserController@create');
        Route::post('/users/store', '\App\Admin\Controllers\UserController@store');
        Route::get('/users/{user}/update', '\App\Admin\Controllers\UserController@update');
        Route::post('/users/{user}/edit', '\App\Admin\Controllers\UserController@edit');
        Route::get('/users/{user}/delete', '\App\Admin\Controllers\UserController@delete')->name('delete');
    });

});