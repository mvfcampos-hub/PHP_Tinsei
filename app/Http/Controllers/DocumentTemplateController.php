<?php

namespace App\Http\Controllers;

use App\Models\DocumentTemplate;

class DocumentTemplateController extends Controller
{
    public function index()
    {
        $templates = DocumentTemplate::active()
            ->with('files')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get()
            ->groupBy(fn (DocumentTemplate $template) => $template->category ?? 'Outros modelos');

        return view('document-templates.index', compact('templates'));
    }
}
