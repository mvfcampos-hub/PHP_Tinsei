<?php

namespace App\Providers;

use App\Models\Campaign;
use App\Models\MenuItem;
use App\Observers\CampaignObserver;
use Illuminate\Support\Facades\Schema;
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
        // Evita "Specified key was too long" em MySQL 5.7/MariaDB mais
        // antigos (comuns em hospedagem compartilhada) ao criar índices
        // únicos em colunas VARCHAR com charset utf8mb4.
        Schema::defaultStringLength(191);

        Campaign::observe(CampaignObserver::class);

        View::composer('layouts.app', function ($view) {
            $view->with(
                'mainMenu',
                MenuItem::whereNull('parent_id')->with('children.children')->orderBy('sort_order')->get()
            );
        });
    }
}
