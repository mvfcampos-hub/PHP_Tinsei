<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\CampaignEpisode;
use App\Models\CouncilGroup;
use App\Models\CouncilMember;
use App\Models\EducationInstitution;
use App\Models\EventItem;
use App\Models\Faq;
use App\Models\Inspector;
use App\Models\JobListing;
use App\Models\User;
use App\Models\Licitacao;
use App\Models\LicitacaoDocument;
use App\Models\LibraryDocument;
use App\Models\LibraryDocumentFile;
use App\Models\Magazine;
use App\Models\MunicipalityProfessionalCount;
use App\Models\News;
use App\Models\Page;
use App\Models\PodeNaoPodeQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_news_index_and_show(): void
    {
        $news = News::create([
            'title' => 'Notícia de teste',
            'slug' => 'noticia-de-teste',
            'excerpt' => 'Resumo de teste',
            'body' => '<p>Conteúdo de teste</p>',
            'category' => 'Institucional',
            'is_featured' => true,
            'published_at' => now()->subDay(),
        ]);

        $this->get(route('news.index'))->assertStatus(200)->assertSee($news->title);
        $this->get(route('news.show', $news->slug))->assertStatus(200)->assertSee($news->title);
    }

    public function test_unpublished_news_returns_404(): void
    {
        $news = News::create([
            'title' => 'Notícia futura',
            'slug' => 'noticia-futura',
            'body' => '<p>Conteúdo</p>',
            'published_at' => now()->addWeek(),
        ]);

        $this->get(route('news.show', $news->slug))->assertStatus(404);
    }

    public function test_page_show(): void
    {
        $page = Page::create([
            'title' => 'Página de teste',
            'slug' => 'pagina-de-teste',
            'content' => '<p>Conteúdo institucional de teste</p>',
            'is_published' => true,
        ]);

        $this->get(route('pages.show', $page->slug))->assertStatus(200)->assertSee($page->title);
    }

    public function test_jobs_index_and_show(): void
    {
        $job = JobListing::create([
            'title' => 'Vaga de teste',
            'slug' => 'vaga-de-teste',
            'company' => 'Empresa Teste',
            'description' => 'Descrição da vaga de teste.',
            'is_active' => true,
            'published_at' => now()->subDay(),
        ]);

        $this->get(route('jobs.index'))->assertStatus(200)->assertSee($job->title);
        $this->get(route('jobs.show', $job->slug))->assertStatus(200)->assertSee($job->title);
    }

    public function test_events_index(): void
    {
        EventItem::create([
            'title' => 'Evento de teste',
            'slug' => 'evento-de-teste',
            'location' => 'Belo Horizonte/MG',
            'starts_at' => now()->addWeek(),
        ]);

        $this->get(route('events.index'))->assertStatus(200)->assertSee('Evento de teste');
    }

    public function test_magazines_index(): void
    {
        Magazine::create([
            'title' => 'Revista de teste',
            'edition' => 'Edição teste',
            'year' => now()->year,
        ]);

        $this->get(route('magazines.index'))->assertStatus(200)->assertSee('Revista de teste');
    }

    public function test_inspectors_index(): void
    {
        Inspector::create([
            'name' => 'Fiscal de Teste',
            'role' => 'Nutricionista Fiscal',
            'region' => 'Sede (Belo Horizonte)',
            'is_active' => true,
        ]);

        $this->get(route('inspectors.index'))->assertStatus(200)->assertSee('Fiscal de Teste');
    }

    public function test_municipalities_index(): void
    {
        MunicipalityProfessionalCount::create([
            'municipality' => 'Belo Horizonte',
            'state' => 'MG',
            'nutritionists_count' => 80,
            'technicians_count' => 10,
            'legal_entities_count' => 10,
            'total_count' => 100,
        ]);

        $this->get(route('municipalities.index'))->assertStatus(200)->assertSee('Belo Horizonte');
    }

    public function test_council_index(): void
    {
        $group = CouncilGroup::create([
            'name' => 'Diretoria',
            'kind' => 'diretoria',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        CouncilMember::create([
            'council_group_id' => $group->id,
            'name' => 'Membro de Teste',
            'role' => 'Presidente',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->get(route('council.index'))->assertStatus(200)->assertSee('Membro de Teste');
    }

    public function test_licitacoes_index_and_show(): void
    {
        $licitacao = Licitacao::create([
            'title' => 'Pregão Eletrônico de Teste nº 1/2026',
            'slug' => 'pregao-eletronico-de-teste-1-2026',
            'modality' => 'Pregão Eletrônico',
            'number' => '1/2026',
            'year' => 2026,
            'description' => 'Objeto de teste.',
            'status' => 'aberta',
            'published_at' => now(),
            'sort_order' => 1,
            'is_active' => true,
        ]);

        LicitacaoDocument::create([
            'licitacao_id' => $licitacao->id,
            'label' => 'Edital de Teste',
            'external_url' => 'https://crn9.org.br/edital-teste.pdf',
            'sort_order' => 1,
        ]);

        $this->get(route('licitacoes.index'))->assertStatus(200)->assertSee($licitacao->title);
        $this->get(route('licitacoes.show', $licitacao))->assertStatus(200)->assertSee('Edital de Teste');
    }

    public function test_library_documents_index_and_show(): void
    {
        $document = LibraryDocument::create([
            'title' => 'Cartilha de Teste',
            'slug' => 'cartilha-de-teste',
            'description' => 'Descrição de teste.',
            'published_at' => now(),
            'sort_order' => 1,
            'is_active' => true,
        ]);

        LibraryDocumentFile::create([
            'library_document_id' => $document->id,
            'label' => 'Arquivo de Teste',
            'external_url' => 'https://crn9.org.br/cartilha-teste.pdf',
            'sort_order' => 1,
        ]);

        $this->get(route('library.index'))->assertStatus(200)->assertSee($document->title);
        $this->get(route('library.index', ['q' => 'Cartilha']))->assertStatus(200)->assertSee($document->title);
        $this->get(route('library.show', $document))->assertStatus(200)->assertSee('Arquivo de Teste');
    }

    public function test_campaign_show_and_menu_sync(): void
    {
        $acontece = \App\Models\MenuItem::create(['label' => 'Acontece no CRN-9', 'url' => '#', 'sort_order' => 1]);
        \App\Models\MenuItem::create(['label' => 'Campanhas', 'url' => '#', 'parent_id' => $acontece->id, 'sort_order' => 1]);

        $campaign = Campaign::create([
            'title' => 'Campanha de Teste',
            'slug' => 'campanha-de-teste',
            'intro' => '<p>Introdução de teste.</p>',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        CampaignEpisode::create([
            'campaign_id' => $campaign->id,
            'title' => 'Episódio de Teste',
            'youtube_url' => 'https://www.youtube.com/watch?v=abcdef12345',
            'sort_order' => 1,
        ]);

        $this->get(route('campaigns.show', $campaign))
            ->assertStatus(200)
            ->assertSee('Episódio de Teste')
            ->assertSee('https://www.youtube.com/embed/abcdef12345', false);

        $campaign->refresh();
        $this->assertNotNull($campaign->menu_item_id);
        $this->assertSame('Campanha de Teste', $campaign->menuItem->label);
        $this->assertSame('Campanhas', $campaign->menuItem->parent->label);

        $campaign->update(['is_active' => false]);
        $campaign->refresh();
        $this->assertNull($campaign->menu_item_id);

        $this->get(route('campaigns.show', $campaign))->assertStatus(404);
    }

    public function test_faqs_index_and_search(): void
    {
        Faq::create([
            'category' => 'Financeiro',
            'question' => 'Quanto custa a anuidade de teste?',
            'answer' => 'Resposta de teste sobre anuidade.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->get(route('faqs.index'))->assertStatus(200)->assertSee('Quanto custa a anuidade de teste?');
        $this->get(route('faqs.index', ['q' => 'anuidade']))->assertStatus(200)->assertSee('Quanto custa a anuidade de teste?');
        $this->get(route('faqs.index', ['q' => 'termoinexistentexyz']))->assertStatus(200)->assertDontSee('Quanto custa a anuidade de teste?');
    }

    public function test_pode_nao_pode_index_and_search(): void
    {
        PodeNaoPodeQuestion::create([
            'category' => 'Prescrição e Suplementos',
            'question' => 'Pode prescrever suplemento de teste?',
            'answer' => 'Resposta direta de teste.',
            'resolution_reference' => 'Resolução CFN nº 000/2026',
            'template_label' => 'Copiar modelo',
            'template_text' => 'Modelo de teste',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->get(route('pode-nao-pode.index'))
            ->assertStatus(200)
            ->assertSee('Pode prescrever suplemento de teste?')
            ->assertSee('Resolução CFN nº 000/2026')
            ->assertSee('Copiar modelo');

        $this->get(route('pode-nao-pode.index', ['q' => 'suplemento']))->assertStatus(200)->assertSee('Pode prescrever suplemento de teste?');
        $this->get(route('pode-nao-pode.index', ['q' => 'termoinexistentexyz']))->assertStatus(200)->assertDontSee('Pode prescrever suplemento de teste?');
    }

    public function test_fiscalizacao_guide_loads(): void
    {
        $this->get(route('fiscalizacao.guide'))
            ->assertStatus(200)
            ->assertSee('Recebi uma Fiscalização')
            ->assertSee('Portal de Adequação');
    }

    public function test_compliance_submission_upload_and_receipt(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $file = \Illuminate\Http\UploadedFile::fake()->create('comprovante.pdf', 100, 'application/pdf');

        $response = $this->post(route('compliance.store'), [
            'nutritionist_name' => 'Fulana de Tal',
            'crn_number' => '12345',
            'inspection_reference' => 'CF-2026-001',
            'notes' => 'Segue o comprovante solicitado.',
            'files' => [$file],
        ]);

        $submission = \App\Models\ComplianceSubmission::where('nutritionist_name', 'Fulana de Tal')->first();
        $this->assertNotNull($submission);
        $this->assertSame('pending', $submission->status);
        $this->assertCount(1, $submission->files);

        $response->assertRedirect(route('compliance.show', $submission));

        $this->get(route('compliance.show', $submission))
            ->assertStatus(200)
            ->assertSee($submission->protocol)
            ->assertSee('comprovante.pdf');

        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($submission->files->first()->file);
    }

    public function test_education_institutions_index(): void
    {
        EducationInstitution::create([
            'name' => 'Faculdade de Teste',
            'name_key' => 'FACULDADE DE TESTE',
            'city' => 'Belo Horizonte',
            'is_active' => true,
        ]);

        $this->get(route('institutions.index'))->assertStatus(200)->assertSee('Faculdade de Teste');
        $this->get(route('institutions.index', ['q' => 'Belo Horizonte']))->assertStatus(200)->assertSee('Faculdade de Teste');
    }

    public function test_search_finds_matching_news_and_pages(): void
    {
        News::create([
            'title' => 'Campanha de vacinação nutricional',
            'slug' => 'campanha-vacinacao-nutricional',
            'body' => '<p>Conteúdo</p>',
            'published_at' => now()->subDay(),
        ]);

        Page::create([
            'title' => 'Sobre vacinação',
            'slug' => 'sobre-vacinacao',
            'content' => '<p>Informações sobre vacinação para nutricionistas</p>',
        ]);

        $response = $this->get(route('search.index', ['q' => 'vacinação']));

        $response->assertStatus(200)
            ->assertSee('Campanha de vacinação nutricional')
            ->assertSee('Sobre vacinação');
    }

    public function test_search_without_term_shows_prompt(): void
    {
        $this->get(route('search.index'))
            ->assertStatus(200)
            ->assertSee('Digite um termo acima para buscar em todo o site do CRN-9.');
    }

    public function test_search_with_no_matches(): void
    {
        $this->get(route('search.index', ['q' => 'termoinexistentexyz']))
            ->assertStatus(200)
            ->assertSee('Nenhum resultado encontrado');
    }

    public function test_public_can_submit_job_and_it_stays_hidden_until_approved(): void
    {
        $response = $this->post(route('jobs.submit.store'), [
            'title' => 'Nutricionista Voluntário',
            'description' => 'Descrição da vaga de teste.',
            'submitter_name' => 'Fulano de Tal',
            'submitter_email' => 'fulano@example.com',
        ]);

        $job = JobListing::where('title', 'Nutricionista Voluntário')->first();
        $this->assertNotNull($job);
        $this->assertSame('pending', $job->status);
        $this->assertFalse($job->is_active);
        $this->assertNotNull($job->removal_token);

        $response->assertRedirect(route('jobs.manage', $job->removal_token));

        $this->get(route('jobs.index'))->assertDontSee('Nutricionista Voluntário');

        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin)
            ->get(\App\Filament\Resources\JobListingResource::getUrl('index'))
            ->assertStatus(200);

        $job->update(['status' => 'approved', 'is_active' => true, 'published_at' => now()]);

        $this->get(route('jobs.index'))->assertSee('Nutricionista Voluntário');
    }

    public function test_submitter_can_request_removal_via_token(): void
    {
        $job = JobListing::create([
            'title' => 'Vaga a ser removida',
            'slug' => 'vaga-a-ser-removida',
            'description' => 'Descrição.',
            'status' => 'approved',
            'is_active' => true,
            'published_at' => now(),
            'submitter_name' => 'Ciclana',
            'submitter_email' => 'ciclana@example.com',
            'removal_token' => JobListing::generateRemovalToken(),
        ]);

        $this->get(route('jobs.manage', $job->removal_token))->assertStatus(200)->assertSee('Vaga a ser removida');

        $this->post(route('jobs.remove', $job->removal_token))
            ->assertRedirect(route('jobs.manage', $job->removal_token));

        $job->refresh();
        $this->assertFalse($job->is_active);
        $this->assertNotNull($job->removal_requested_at);

        $this->get(route('jobs.index'))->assertDontSee('Vaga a ser removida');
    }
}
