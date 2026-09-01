<?php

namespace App\Http\Controllers;

use App\Models\LibraryDocument;
use Illuminate\Http\Request;

class LibraryDocumentController extends Controller
{
    public function index(Request $request)
    {
        $documents = LibraryDocument::active()
            ->withCount('files')
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%'.$request->string('q').'%';
                $query->where(function ($query) use ($term) {
                    $query->where('title', 'like', $term)
                        ->orWhere('description', 'like', $term);
                });
            })
            ->orderByDesc('published_at')
            ->orderBy('title')
            ->paginate(12)
            ->withQueryString();

        return view('library.index', compact('documents'));
    }

    public function show(LibraryDocument $document)
    {
        $document->load('files');

        return view('library.show', compact('document'));
    }
}
