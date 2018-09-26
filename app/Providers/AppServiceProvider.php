<?php

namespace App\Providers;

use App\Topic;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;  // 必须的

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        //  数据库不是 mysqli的 需要写个码 767/4 = 191
        Schema::defaultStringLength(191); // 191
        \View::composer('layout.sidebar', function ($view) {
            // with 注入
            $topics = Topic::all();
            $view->with('topics', $topics);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
