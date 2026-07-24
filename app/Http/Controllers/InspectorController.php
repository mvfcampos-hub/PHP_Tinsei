<?php

namespace App\Http\Controllers;

use App\Models\Inspector;
use Illuminate\Http\Request;

class InspectorController extends Controller
{
    public function __invoke(Request $request)
    {
        $inspectors = Inspector::active()->get();

        return view('inspectors.index', compact('inspectors'));
    }
}
