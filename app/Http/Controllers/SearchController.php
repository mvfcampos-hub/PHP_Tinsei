<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\Magazine;
use App\Models\News;
use App\Models\Page;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $term = trim((string) $request->query('q', ''));

        $results = collect();

        if ($term !== '') {
            $results = $results
                ->concat($this->searchNews($term))
                ->concat($this->searchPages($term))
                ->concat($this->searchJobs($term))
                ->concat($this->searchMagazines($term));
        }

        return view('search.index', [
            'term' => $term,
            'results' => $results,
        ]);
    }

    private function searchNews(string $term)
    {
        return News::published()
            ->where(fn ($query) => $query
                ->where('title', 'like', "%{$term}%")
                ->orWhere('excerpt', 'like', "%{$term}%")
                ->orWhere('body', 'like', "%{$term}%"))
            ->latest('published_at')
            ->take(10)
            ->get()
            ->map(fn (News $news) => [
                'type' => 'Notícia',
                'title' => $news->title,
                'excerpt' => $news->excerpt,
                'url' => route('news.show', $news->slug),
            ]);
    }

    private function searchPages(string $term)
    {
        return Page::published()
            ->where(fn ($query) => $query
                ->where('title', 'like', "%{$term}%")
                ->orWhere('content', 'like', "%{$term}%"))
            ->take(10)
            ->get()
            ->map(fn (Page $page) => [
                'type' => 'Página institucional',
                'title' => $page->title,
                'excerpt' => str(strip_tags($page->content))->limit(160),
                'url' => route('pages.show', $page->slug),
            ]);
    }

    private function searchJobs(string $term)
    {
        return JobListing::active()
            ->where(fn ($query) => $query
                ->where('title', 'like', "%{$term}%")
                ->orWhere('company', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%"))
            ->take(10)
            ->get()
            ->map(fn (JobListing $job) => [
                'type' => 'Vaga',
                'title' => $job->title,
                'excerpt' => $job->company,
                'url' => route('jobs.show', $job->slug),
            ]);
    }

    private function searchMagazines(string $term)
    {
        return Magazine::where('title', 'like', "%{$term}%")
            ->orWhere('edition', 'like', "%{$term}%")
            ->take(10)
            ->get()
            ->map(fn (Magazine $magazine) => [
                'type' => 'Revista',
                'title' => $magazine->title.($magazine->edition ? " — {$magazine->edition}" : ''),
                'excerpt' => null,
                'url' => route('magazines.index'),
            ]);
    }
}
