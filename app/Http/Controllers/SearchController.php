<?php

namespace App\Http\Controllers;

use App\Models\EventItem;
use App\Models\KnowledgeArticle;
use App\Models\News;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $term = trim((string) $request->query('q', ''));

        $products = collect();
        $news = collect();
        $pages = collect();
        $events = collect();
        $articles = collect();

        if ($term !== '') {
            $like = '%'.$term.'%';

            $products = Product::active()
                ->where(function ($query) use ($like) {
                    $query->where('name', 'like', $like)
                        ->orWhere('tagline', 'like', $like)
                        ->orWhere('summary', 'like', $like)
                        ->orWhere('description', 'like', $like);
                })
                ->orderBy('sort_order')
                ->get();

            $news = News::published()
                ->where(function ($query) use ($like) {
                    $query->where('title', 'like', $like)
                        ->orWhere('excerpt', 'like', $like)
                        ->orWhere('body', 'like', $like);
                })
                ->latest('published_at')
                ->get();

            $pages = Page::published()
                ->where(function ($query) use ($like) {
                    $query->where('title', 'like', $like)
                        ->orWhere('content', 'like', $like);
                })
                ->get();

            $events = EventItem::where(function ($query) use ($like) {
                $query->where('title', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhere('location', 'like', $like);
            })
                ->orderBy('starts_at', 'desc')
                ->get();

            $articles = KnowledgeArticle::published()
                ->where(function ($query) use ($like) {
                    $query->where('title', 'like', $like)
                        ->orWhere('excerpt', 'like', $like)
                        ->orWhere('content', 'like', $like);
                })
                ->orderBy('sort_order')
                ->get();
        }

        $totalResults = $products->count() + $news->count() + $pages->count() + $events->count() + $articles->count();

        return view('search.index', compact('term', 'products', 'news', 'pages', 'events', 'articles', 'totalResults'));
    }
}
