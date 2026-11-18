<?php

namespace App\Providers;

use App\Models\Banner;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Compatibilidade com MySQL 5.6 (KingHost): índices em utf8mb4 limitados a 767 bytes.
        Schema::defaultStringLength(191);

        View::composer('layouts.app', function ($view) {
            $view->with('mainMenu', MenuItem::whereNull('parent_id')->with(['children', 'page'])->orderBy('sort_order')->get());
        });

        View::composer('partials.notice-banner', function ($view) {
            $view->with('globalNoticeBanners', Banner::active()->placement('home_notice')->get());
        });
    }
}
