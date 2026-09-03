<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeArticle;
use App\Models\News;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = collect();

        // Páginas estáticas do site.
        $staticRoutes = [
            ['route' => 'home', 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['route' => 'products.index', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['route' => 'cloud.show', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['route' => 'it-services.show', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['route' => 'msp.show', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['route' => 'databackup.show', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['route' => 'hardware.index', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['route' => 'news.index', 'priority' => '0.7', 'changefreq' => 'daily'],
            ['route' => 'events.index', 'priority' => '0.6', 'changefreq' => 'weekly'],
            ['route' => 'kb.index', 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['route' => 'success-stories.index', 'priority' => '0.7', 'changefreq' => 'monthly'],
        ];

        foreach ($staticRoutes as $item) {
            $urls->push([
                'loc' => route($item['route']),
                'lastmod' => now()->toAtomString(),
                'changefreq' => $item['changefreq'],
                'priority' => $item['priority'],
            ]);
        }

        foreach (Product::active()->where('opens_externally', false)->get() as $product) {
            $urls->push([
                'loc' => route('products.show', $product->slug),
                'lastmod' => $product->updated_at->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ]);
        }

        foreach (News::published()->get() as $article) {
            $urls->push([
                'loc' => route('news.show', $article->slug),
                'lastmod' => $article->updated_at->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ]);
        }

        foreach (Page::published()->get() as $page) {
            $urls->push([
                'loc' => route('pages.show', $page->slug),
                'lastmod' => $page->updated_at->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.5',
            ]);
        }

        foreach (KnowledgeArticle::published()->get() as $article) {
            $urls->push([
                'loc' => route('kb.show', $article->slug),
                'lastmod' => $article->updated_at->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ]);
        }

        $xml = view('sitemap', ['urls' => $urls])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
