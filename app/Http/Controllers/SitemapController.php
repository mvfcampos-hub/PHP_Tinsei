<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Page;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = collect([
            ['home', '1.0', 'weekly'],
            ['about', '0.9', 'monthly'],
            ['portfolio', '0.9', 'weekly'],
            ['sustainability', '0.8', 'monthly'],
            ['presence', '0.7', 'monthly'],
            ['testimonials', '0.6', 'monthly'],
            ['news.index', '0.8', 'daily'],
            ['events.index', '0.7', 'weekly'],
            ['contact.index', '0.7', 'yearly'],
            ['careers.index', '0.5', 'monthly'],
        ])->map(fn ($r) => [
            'loc' => route($r[0]),
            'lastmod' => now()->toAtomString(),
            'priority' => $r[1],
            'changefreq' => $r[2],
        ]);

        foreach (News::published()->get() as $article) {
            $urls->push(['loc' => route('news.show', $article->slug), 'lastmod' => $article->updated_at->toAtomString(), 'changefreq' => 'monthly', 'priority' => '0.6']);
        }

        foreach (Page::published()->get() as $page) {
            $urls->push(['loc' => route('pages.show', $page->slug), 'lastmod' => $page->updated_at->toAtomString(), 'changefreq' => 'yearly', 'priority' => '0.3']);
        }

        return response(view('sitemap', ['urls' => $urls])->render(), 200)->header('Content-Type', 'application/xml');
    }
}
