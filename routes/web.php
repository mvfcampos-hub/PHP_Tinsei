<?php

use App\Http\Controllers\CloudController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItServiceController;
use App\Http\Controllers\KnowledgeBaseController;
use App\Http\Controllers\MspController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

// Sistemas: o ecossistema de software da Databit (ERP DataClassic e módulos
// integrados). Rota renomeada de /produtos para /sistemas para não colidir
// com a vitrine de produtos de informática (hardware), que usa o nome
// "Produtos" no site atual da Databit.
Route::get('/sistemas', [ProductController::class, 'index'])->name('products.index');
Route::get('/sistemas/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/datacloud', CloudController::class)->name('cloud.show');

Route::get('/servicos-ti', ItServiceController::class)->name('it-services.show');
Route::get('/servicos-ti/msp', MspController::class)->name('msp.show');

Route::get('/produtos', HardwareController::class)->name('hardware.index');

Route::get('/novidades', [NewsController::class, 'index'])->name('news.index');
Route::get('/novidades/{news:slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/agenda', [EventController::class, 'index'])->name('events.index');

Route::get('/paginas/{page:slug}', [PageController::class, 'show'])->name('pages.show');

Route::get('/busca', SearchController::class)->name('search');

Route::get('/base-de-conhecimento', [KnowledgeBaseController::class, 'index'])->name('kb.index');
Route::get('/base-de-conhecimento/{article:slug}', [KnowledgeBaseController::class, 'show'])->name('kb.show');
