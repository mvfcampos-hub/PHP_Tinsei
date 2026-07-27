<?php

use App\Http\Controllers\CouncilController;
use App\Http\Controllers\EducationInstitutionController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InspectorController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\JobSubmissionController;
use App\Http\Controllers\LicitacaoController;
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
Route::get('/vagas/cadastrar', [JobSubmissionController::class, 'create'])->name('jobs.submit');
Route::post('/vagas/cadastrar', [JobSubmissionController::class, 'store'])->name('jobs.submit.store');
Route::get('/vagas/gerenciar/{token}', [JobSubmissionController::class, 'manage'])->name('jobs.manage');
Route::post('/vagas/gerenciar/{token}/remover', [JobSubmissionController::class, 'requestRemoval'])->name('jobs.remove');
Route::get('/vagas/{job:slug}', [JobListingController::class, 'show'])->name('jobs.show');

Route::get('/revistas', [MagazineController::class, 'index'])->name('magazines.index');

Route::get('/fiscalizacao', InspectorController::class)->name('inspectors.index');

Route::get('/plenario', CouncilController::class)->name('council.index');

Route::get('/licitacoes', [LicitacaoController::class, 'index'])->name('licitacoes.index');
Route::get('/licitacoes/{licitacao:slug}', [LicitacaoController::class, 'show'])->name('licitacoes.show');

Route::get('/profissionais-por-municipio', MunicipalityController::class)->name('municipalities.index');

Route::get('/instituicoes-de-ensino', [EducationInstitutionController::class, 'index'])->name('institutions.index');

Route::get('/paginas/{page:slug}', [PageController::class, 'show'])->name('pages.show');
