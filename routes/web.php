<?php

use App\Http\Controllers\CloudController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/produtos', [ProductController::class, 'index'])->name('products.index');
Route::get('/produtos/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/datacloud', CloudController::class)->name('cloud.show');

Route::get('/novidades', [NewsController::class, 'index'])->name('news.index');
Route::get('/novidades/{news:slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/agenda', [EventController::class, 'index'])->name('events.index');

Route::get('/paginas/{page:slug}', [PageController::class, 'show'])->name('pages.show');
