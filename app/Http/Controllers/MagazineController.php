<?php

namespace App\Http\Controllers;

use App\Models\Magazine;

class MagazineController extends Controller
{
    public function index()
    {
        $magazines = Magazine::orderByDesc('year')->orderByDesc('published_at')->paginate(12);

        return view('magazines.index', compact('magazines'));
    }
}
