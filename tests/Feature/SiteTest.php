<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_public_pages_load(): void
    {
        foreach (['/', '/sobre', '/portfolio', '/sustentabilidade', '/onde-estamos', '/depoimentos', '/noticias',
            '/noticias/tinsei-na-revista-pegn', '/agenda', '/contato', '/trabalhe-conosco',
            '/paginas/politica-de-privacidade', '/busca?q=xerox', '/sitemap.xml', '/robots.txt'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_home_shows_client_map_and_store_link(): void
    {
        $this->get('/')
            ->assertSee('3.230')
            ->assertSee('Minas Gerais')
            ->assertSee('https://loja.tinsei.com.br/', false);
    }

    public function test_unpublished_content_is_hidden(): void
    {
        $this->get('/agenda')->assertDontSee('EXEMPLO');
        $this->get('/depoimentos')->assertDontSee('EXEMPLO');
    }

    public function test_contact_form_stores_message(): void
    {
        $this->post('/contato', [
            'subject_type' => 'revenda',
            'name' => 'Maria Teste',
            'email' => 'maria@example.com',
            'state' => 'MG',
            'message' => 'Quero ser revenda.',
            'consent' => '1',
        ])->assertRedirect('/contato');

        $this->assertDatabaseHas('contact_messages', ['email' => 'maria@example.com', 'status' => 'novo']);
    }

    public function test_contact_form_requires_consent(): void
    {
        $this->post('/contato', ['subject_type' => 'contato', 'name' => 'X', 'email' => 'x@example.com', 'message' => 'Oi'])
            ->assertSessionHasErrors('consent');

        $this->assertSame(0, ContactMessage::count());
    }

    public function test_admin_panel_pages_load_for_admin(): void
    {
        $admin = User::where('is_admin', true)->first();

        foreach (['/admin', '/admin/news', '/admin/event-items', '/admin/testimonials', '/admin/timeline-events',
            '/admin/partners', '/admin/portfolio-categories', '/admin/brands', '/admin/state-client-counts',
            '/admin/contact-messages', '/admin/banners', '/admin/pages', '/admin/menu-items', '/admin/users',
            '/admin/site-settings', '/admin/news/create', '/admin/state-client-counts/1/edit'] as $url) {
            $this->actingAs($admin)->get($url)->assertOk();
        }
    }

    public function test_noindex_mode_blocks_search_engines(): void
    {
        config(['app.noindex' => true]);

        $this->get('/robots.txt')->assertSee('Disallow: /');
        $this->get('/')->assertSee('noindex, nofollow', false);
    }

    public function test_admin_requires_admin_flag(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get('/admin')->assertForbidden();
    }
}
