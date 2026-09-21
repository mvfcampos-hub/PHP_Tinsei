<?php

namespace App\Http\Controllers;

use App\Models\PodeNaoPodeQuestion;
use Illuminate\Http\Request;

class PodeNaoPodeController extends Controller
{
    public function index(Request $request)
    {
        $questions = PodeNaoPodeQuestion::active()
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%'.$request->string('q').'%';
                $query->where(function ($query) use ($term) {
                    $query->where('question', 'like', $term)
                        ->orWhere('answer', 'like', $term)
                        ->orWhere('category', 'like', $term);
                });
            })
            ->orderBy('category')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');

        return view('pode-nao-pode.index', compact('questions'));
    }
}
