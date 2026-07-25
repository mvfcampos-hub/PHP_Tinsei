<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InspectorController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\MagazineController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/busca', [SearchController::class, 'index'])->name('search.index');

Route::get('/noticias', [NewsController::class, 'index'])->name('news.index');
Route::get('/noticias/{news:slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/agenda', [EventController::class, 'index'])->name('events.index');

Route::get('/vagas', [JobListingController::class, 'index'])->name('jobs.index');
Route::get('/vagas/{job:slug}', [JobListingController::class, 'show'])->name('jobs.show');

Route::get('/revistas', [MagazineController::class, 'index'])->name('magazines.index');

Route::get('/fiscalizacao', InspectorController::class)->name('inspectors.index');

Route::get('/profissionais-por-municipio', MunicipalityController::class)->name('municipalities.index');

Route::get('/paginas/{page:slug}', [PageController::class, 'show'])->name('pages.show');
