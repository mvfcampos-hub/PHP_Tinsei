<?php

namespace App\Http\Controllers;

use App\Models\EventItem;
use App\Models\News;
use App\Models\Page;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $term = trim((string) $request->query('q', ''));
        $news = $pages = $events = collect();

        if (mb_strlen($term) >= 2) {
            $like = '%'.$term.'%';

            $news = News::published()
                ->where(fn ($q) => $q->where('title', 'like', $like)->orWhere('excerpt', 'like', $like)->orWhere('body', 'like', $like))
                ->latest('published_at')
                ->take(20)
                ->get();

            $pages = Page::published()
                ->where(fn ($q) => $q->where('title', 'like', $like)->orWhere('content', 'like', $like))
                ->get();

            $events = EventItem::published()
                ->where(fn ($q) => $q->where('title', 'like', $like)->orWhere('description', 'like', $like)->orWhere('location', 'like', $like))
                ->orderByDesc('starts_at')
                ->get();
        }

        $totalResults = $news->count() + $pages->count() + $events->count();

        return view('search.index', compact('term', 'news', 'pages', 'events', 'totalResults'));
    }
}
