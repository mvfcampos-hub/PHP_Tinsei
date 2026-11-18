<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('categoria');

        $news = News::published()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $categories = News::published()->whereNotNull('category')->distinct()->orderBy('category')->pluck('category');

        return view('news.index', compact('news', 'categories', 'category'));
    }

    public function show(News $news)
    {
        abort_unless($news->published_at && $news->published_at->isPast(), 404);

        $related = News::published()
            ->where('id', '!=', $news->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('news.show', compact('news', 'related'));
    }
}
