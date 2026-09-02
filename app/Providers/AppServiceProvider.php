<?php

namespace App\Providers;

use App\Models\Banner;
use App\Models\MenuItem;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $view->with(
                'mainMenu',
                MenuItem::whereNull('parent_id')->with('children')->orderBy('sort_order')->get()
            );
        });

        View::composer('partials.notice-banner', function ($view) {
            $view->with(
                'globalNoticeBanners',
                Banner::active()->placement('home_notice')->get()
            );
        });
    }
}
