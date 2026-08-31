<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\CampaignEpisode;
use App\Models\CouncilGroup;
use App\Models\CouncilMember;
use App\Models\DocumentTemplate;
use App\Models\DocumentTemplateFile;
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

    public function test_cookie_notice_is_present_on_every_page(): void
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('cookies estritamente necessários', false)
            ->assertSee(route('pages.show', 'politica-de-cookies'), false);
    }

    public function test_lgpd_and_cookie_policy_pages_load(): void
    {
        $lgpd = Page::create([
            'title' => 'Política de Privacidade e Proteção de Dados (LGPD)',
            'slug' => 'lgpd',
            'content' => '<p>Conteúdo LGPD de teste</p>',
            'is_published' => true,
        ]);
        $cookies = Page::create([
            'title' => 'Política de Cookies',
            'slug' => 'politica-de-cookies',
            'content' => '<p>Conteúdo de cookies de teste</p>',
            'is_published' => true,
        ]);

        $this->get(route('pages.show', $lgpd->slug))->assertStatus(200)->assertSee($lgpd->title);
        $this->get(route('pages.show', $cookies->slug))->assertStatus(200)->assertSee($cookies->title);
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

    public function test_events_calendar_shows_event_in_current_month(): void
    {
        EventItem::create([
            'title' => 'Reunião de teste no calendário',
            'slug' => 'reuniao-de-teste-no-calendario',
            'starts_at' => now()->startOfMonth()->addDays(4),
        ]);

        $this->get(route('events.index'))->assertStatus(200)->assertSee('Reunião de teste no calendário');
    }

    public function test_events_calendar_month_navigation(): void
    {
        // The "Próximos eventos" list shows all future events regardless of
        // month, so this only asserts the calendar header reflects the
        // requested month (the list itself is covered by other tests).
        $nextMonth = now()->addMonthsNoOverflow(2);

        $this->get(route('events.index', ['month' => $nextMonth->format('Y-m')]))
            ->assertStatus(200)
            ->assertSee($nextMonth->translatedFormat('F \d\e Y'));
    }

    public function test_cfn_calendar_sync_creates_and_updates_events(): void
    {
        $ics = <<<ICS
        BEGIN:VCALENDAR
        VERSION:2.0
        BEGIN:VEVENT
        DTSTART;VALUE=DATE:20260901
        DTEND;VALUE=DATE:20260902
        UID:test-uid-001@calendario.cfn.org.br
        SUMMARY:Evento CFN de teste
        DESCRIPTION:Descrição de teste
        URL:https://calendario.cfn.org.br/evento/teste/
        LOCATION:Brasília\, DF
        END:VEVENT
        END:VCALENDAR
        ICS;

        \Illuminate\Support\Facades\Http::fake([
            'calendario.cfn.org.br/*' => \Illuminate\Support\Facades\Http::response($ics, 200),
        ]);

        $result = app(\App\Services\CfnCalendarSync::class)->sync();

        $this->assertSame(1, $result['created']);
        $this->assertSame(0, $result['updated']);

        $event = EventItem::where('external_uid', 'test-uid-001@calendario.cfn.org.br')->first();
        $this->assertNotNull($event);
        $this->assertSame('Evento CFN de teste', $event->title);
        $this->assertSame('cfn_sync', $event->source);

        // Re-sync should update, not duplicate.
        $result = app(\App\Services\CfnCalendarSync::class)->sync();
        $this->assertSame(0, $result['created']);
        $this->assertSame(1, $result['updated']);
        $this->assertSame(1, EventItem::where('external_uid', 'test-uid-001@calendario.cfn.org.br')->count());
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

    public function test_staffing_calculators_page_loads(): void
    {
        $this->get(route('tools.calculators'))
            ->assertStatus(200)
            ->assertSee('Calculadoras de Dimensionamento de Equipe')
            ->assertSee('Alimentação Coletiva / UAN')
            ->assertSee('Área Hospitalar / SND')
            ->assertSee('Resolução CFN nº 380/2005');
    }

    public function test_document_templates_index_lists_downloadable_files(): void
    {
        $template = DocumentTemplate::create([
            'title' => 'Modelo de teste',
            'slug' => 'modelo-de-teste',
            'category' => 'Atendimento Clínico',
            'description' => 'Descrição de teste.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        DocumentTemplateFile::create([
            'document_template_id' => $template->id,
            'label' => 'Baixar modelo (Word/RTF)',
            'file' => 'modelos-editaveis/modelo-de-teste.rtf',
            'sort_order' => 1,
        ]);

        $this->get(route('document-templates.index'))
            ->assertStatus(200)
            ->assertSee('Repositório de Modelos Editáveis')
            ->assertSee('Atendimento Clínico')
            ->assertSee('Modelo de teste')
            ->assertSee('Baixar modelo (Word/RTF)');
    }

    public function test_fiscalizacao_numeros_page_loads(): void
    {
        \App\Models\FiscalizacaoStat::create([
            'label' => 'Visitas realizadas',
            'value' => '420 (exemplo)',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->get(route('fiscalizacao.numeros'))
            ->assertStatus(200)
            ->assertSee('Fiscalização em Números')
            ->assertSee('Visitas realizadas')
            ->assertSee('420 (exemplo)');
    }

    public function test_fiscalizacao_processos_page_loads(): void
    {
        \App\Models\FiscalizacaoProcess::create([
            'category' => 'Ética: conduta inadequada',
            'code' => 'A12',
            'subject' => 'ILPI',
            'started_at' => '2024-01-01',
            'status' => 'No jurídico',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->get(route('fiscalizacao.processos'))
            ->assertStatus(200)
            ->assertSee('Processos de Fiscalização e Ética em Andamento')
            ->assertSee('A12')
            ->assertSee('ILPI')
            ->assertSee('No jurídico')
            ->assertSee('2024');
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

    public function test_nutrition_stories_index_and_show(): void
    {
        $story = \App\Models\NutritionStory::create([
            'title' => 'História de teste',
            'slug' => 'historia-de-teste',
            'area' => 'Hospitais',
            'region' => 'Belo Horizonte/MG',
            'summary' => 'Resumo de teste.',
            'body' => 'Corpo da história de teste.',
            'status' => 'published',
            'is_active' => true,
            'published_at' => now(),
        ]);

        $this->get(route('nutrition-stories.index'))->assertStatus(200)->assertSee('História de teste');
        $this->get(route('nutrition-stories.index', ['area' => 'Hospitais']))->assertStatus(200)->assertSee('História de teste');
        $this->get(route('nutrition-stories.index', ['area' => 'Consultórios']))->assertStatus(200)->assertDontSee('História de teste');
        $this->get(route('nutrition-stories.show', $story))->assertStatus(200)->assertSee('Corpo da história de teste.');
    }

    public function test_pending_nutrition_story_is_hidden_until_published(): void
    {
        $story = \App\Models\NutritionStory::create([
            'title' => 'História pendente',
            'slug' => 'historia-pendente',
            'area' => 'Consultórios',
            'region' => 'Belo Horizonte/MG',
            'summary' => 'Resumo.',
            'body' => 'Corpo.',
            'status' => 'pending',
            'is_active' => false,
        ]);

        $this->get(route('nutrition-stories.index'))->assertDontSee('História pendente');
        $this->get(route('nutrition-stories.show', $story))->assertStatus(404);
    }

    public function test_public_can_suggest_a_nutrition_story(): void
    {
        $response = $this->post(route('nutrition-stories.suggest.store'), [
            'title' => 'Indicação de teste',
            'area' => 'Segurança Alimentar e Nutricional',
            'region' => 'Ipatinga/MG',
            'summary' => 'Resumo da indicação.',
            'body' => 'História completa da indicação.',
            'submitter_name' => 'Fulano de Tal',
            'submitter_email' => 'fulano@example.com',
        ]);

        $story = \App\Models\NutritionStory::where('title', 'Indicação de teste')->first();
        $this->assertNotNull($story);
        $this->assertSame('pending', $story->status);
        $this->assertFalse($story->is_active);

        $response->assertRedirect(route('nutrition-stories.index'));
        $this->get(route('nutrition-stories.index'))->assertDontSee('Indicação de teste');
    }

    public function test_new_graduate_guide_loads(): void
    {
        $this->get(route('orientacao.guia-recem-formado'))
            ->assertStatus(200)
            ->assertSee('Guia do Recém-Formado')
            ->assertSee('Emita seu registro no CRN-9')
            ->assertSee('Prepare seu consultório');
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
