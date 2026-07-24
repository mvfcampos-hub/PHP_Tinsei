<?php

namespace App\Http\Controllers;

use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::published()->latest('published_at')->paginate(9);

        return view('news.index', compact('news'));
    }

    public function show(News $news)
    {
        abort_unless($news->published_at && $news->published_at->isPast(), 404);

        $related = News::published()
            ->where('id', '!=', $news->id)
            ->when($news->category, fn ($query) => $query->where('category', $news->category))
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('news.show', compact('news', 'related'));
    }
}
