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

        // 使用Gate验证权限
        Route::group(['middleware' => 'can:system'], function () {
            // 用户管理模块
            Route::get('/users', '\App\Admin\Controllers\UserController@index');
            Route::get('/users/create', '\App\Admin\Controllers\UserController@create');
            Route::post('/users/store', '\App\Admin\Controllers\UserController@store');
            Route::get('/users/{user}/update', '\App\Admin\Controllers\UserController@update');
            Route::post('/users/{user}/edit', '\App\Admin\Controllers\UserController@edit');
            Route::get('/users/{user}/delete', '\App\Admin\Controllers\UserController@delete')->name('delete');
            Route::get('/users/{user}/role', '\App\Admin\Controllers\UserController@role');
            Route::post('/users/{user}/role', '\App\Admin\Controllers\UserController@storeRole');

            // 角色
            Route::get('/roles', '\App\Admin\Controllers\RoleController@index');
            Route::get('/roles/create', '\App\Admin\Controllers\RoleController@create');
            Route::post('/roles/store', '\App\Admin\Controllers\RoleController@store');
            Route::get('/roles/{role}/permission', '\App\Admin\Controllers\RoleController@permission');
            Route::post('/roles/{role}/permission', '\App\Admin\Controllers\RoleController@storePermission');
            Route::get('/roles/{role}/update', '\App\Admin\Controllers\RoleController@update');
            Route::post('/roles/{role}/edit', '\App\Admin\Controllers\RoleController@edit');
            Route::get('/roles/{role}/delete', '\App\Admin\Controllers\RoleController@delete');

            // 权限
            Route::get('/permissions', '\App\Admin\Controllers\PermissionController@index');
            Route::get('/permissions/create', '\App\Admin\Controllers\PermissionController@create');
            Route::post('/permissions/store', '\App\Admin\Controllers\PermissionController@store');
            Route::get('/permissions/{permission}/update', '\App\Admin\Controllers\PermissionController@update');
            Route::post('/permissions/{permission}/edit', '\App\Admin\Controllers\PermissionController@edit');
            Route::get('/permissions/{permission}/delete', '\App\Admin\Controllers\PermissionController@delete');
        });
        Route::group(['middleware' => 'can:post'], function () {
            // 文章审核
            Route::get('/posts', '\App\Admin\Controllers\PostController@index');
            Route::post('/posts/{post}/status', '\App\Admin\Controllers\PostController@status');
        });
        // 专题模块
        Route::group(['middleware' => 'can:topic'], function () {
            Route::resource('/topics', '\App\Admin\Controllers\TopicController', ['only' => ['index', 'create', 'store', 'destroy']]);
        });

        // 通知模块
        Route::group(['middleware' => 'can:notice'], function () {
            Route::resource('/notices', '\App\Admin\Controllers\NoticeController', ['only' => ['index', 'create', 'store']]);
        });
    });

});