<?php
Route::group(['prefix' => '/admin'], function (){
    Route::get('/login', function (){
        return "This is admin login";
    });
});