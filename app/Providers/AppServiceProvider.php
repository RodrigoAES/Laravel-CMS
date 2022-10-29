<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Page;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        //MENU
        $frontMenu = ['/' => 'Home'];
        $pages = Page::all();
        foreach($pages as $page) {
            $frontMenu[$page['slug']] = $page['title'];
        }
        View::share('frontMenu', $frontMenu);

        //CONFIG
        foreach(Setting::all() as $setting) {
            $config[$setting['name']] = $setting['content'];
        }
        View::share('frontConfig', $config);
    }
}
