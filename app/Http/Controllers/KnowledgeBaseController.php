<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeArticle;
use App\Models\Product;
use Illuminate\Http\Request;

class KnowledgeBaseController extends Controller
{
    public function index(Request $request)
    {
        $term = trim((string) $request->query('q', ''));
        $solutionType = $request->query('tipo');
        $moduleId = $request->query('modulo');

        $query = KnowledgeArticle::published()->with('product');

        if ($term !== '') {
            $like = '%'.$term.'%';
            $query->where(function ($inner) use ($like) {
                $inner->where('title', 'like', $like)
                    ->orWhere('excerpt', 'like', $like)
                    ->orWhere('content', 'like', $like);
            });
        }

        if ($solutionType && array_key_exists($solutionType, KnowledgeArticle::SOLUTION_TYPES)) {
            $query->solutionType($solutionType);
        }

        if ($moduleId) {
            $query->where('product_id', $moduleId);
        }

        $articles = $query->orderBy('sort_order')->orderBy('title')->get();
        $grouped = $articles->groupBy('solution_type');

        // Sistemas + DataCloud cobrem todas as categorias de Product — os
        // únicos "módulos" (produtos) que a Base de Conhecimento referencia.
        $modules = Product::active()->orderBy('name')->get(['id', 'name']);

        return view('kb.index', [
            'term' => $term,
            'solutionType' => $solutionType,
            'moduleId' => $moduleId,
            'articles' => $articles,
            'grouped' => $grouped,
            'modules' => $modules,
            'solutionTypes' => KnowledgeArticle::SOLUTION_TYPES,
        ]);
    }

    public function show(KnowledgeArticle $article)
    {
        abort_unless($article->is_published, 404);

        $related = KnowledgeArticle::published()
            ->where('id', '!=', $article->id)
            ->where(function ($query) use ($article) {
                $query->where('solution_type', $article->solution_type);

                if ($article->product_id) {
                    $query->orWhere('product_id', $article->product_id);
                }
            })
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        return view('kb.show', compact('article', 'related'));
    }
}
