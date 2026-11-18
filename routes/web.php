<?php

use App\Http\Controllers\CareerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstitutionalController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::controller(InstitutionalController::class)->group(function () {
    Route::get('/sobre', 'about')->name('about');
    Route::get('/portfolio', 'portfolio')->name('portfolio');
    Route::get('/sustentabilidade', 'sustainability')->name('sustainability');
    Route::get('/onde-estamos', 'presence')->name('presence');
    Route::get('/depoimentos', 'testimonials')->name('testimonials');
});

// Atalho fácil de divulgar para o portfólio completo (loja B2B).
Route::get('/loja', fn () => redirect()->away(setting('store_url')))->name('store');

Route::get('/noticias', [NewsController::class, 'index'])->name('news.index');
Route::get('/noticias/{news:slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/agenda', [EventController::class, 'index'])->name('events.index');

Route::get('/contato', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contato', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

Route::get('/trabalhe-conosco', [CareerController::class, 'index'])->name('careers.index');
Route::post('/trabalhe-conosco', [CareerController::class, 'store'])->middleware('throttle:5,1')->name('careers.store');

Route::get('/paginas/{page:slug}', [PageController::class, 'show'])->name('pages.show');
Route::get('/busca', SearchController::class)->name('search');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', RobotsController::class)->name('robots');
