<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ComplianceSubmissionController;
use App\Http\Controllers\CouncilController;
use App\Http\Controllers\EducationInstitutionController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FiscalizacaoGuideController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InspectorController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\JobSubmissionController;
use App\Http\Controllers\LibraryDocumentController;
use App\Http\Controllers\LicitacaoController;
use App\Http\Controllers\MagazineController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PodeNaoPodeController;
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

Route::get('/biblioteca', [LibraryDocumentController::class, 'index'])->name('library.index');
Route::get('/biblioteca/{document:slug}', [LibraryDocumentController::class, 'show'])->name('library.show');

Route::get('/campanhas/{campaign:slug}', [CampaignController::class, 'show'])->name('campaigns.show');

Route::get('/perguntas-frequentes', [FaqController::class, 'index'])->name('faqs.index');

Route::get('/pode-ou-nao-pode', [PodeNaoPodeController::class, 'index'])->name('pode-nao-pode.index');

Route::get('/fiscalizacao/recebi-uma-fiscalizacao', [FiscalizacaoGuideController::class, 'show'])->name('fiscalizacao.guide');
Route::post('/portal-adequacao', [ComplianceSubmissionController::class, 'store'])->name('compliance.store');
Route::get('/portal-adequacao/{submission:protocol}', [ComplianceSubmissionController::class, 'show'])->name('compliance.show');

Route::get('/paginas/{page:slug}', [PageController::class, 'show'])->name('pages.show');
