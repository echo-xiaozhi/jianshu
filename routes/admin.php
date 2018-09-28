<?php
Route::group(['prefix' => '/admin'], function (){
    // 登录页面
    Route::get('/login', '\App\Admin\Controllers\LoginController@index');
    // 登录行为
    Route::post('/login', '\App\Admin\Controllers\LoginController@login');
    // 登出
    Route::get('/logout', '\App\Admin\Controllers\LoginController@logout');
    // 后台首页
    Route::get('/home', '\App\Admin\Controllers\HomeController@index');
});