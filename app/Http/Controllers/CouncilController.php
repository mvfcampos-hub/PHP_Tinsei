<?php

namespace App\Http\Controllers;

use App\Models\CouncilGroup;
use Illuminate\Http\Request;

class CouncilController extends Controller
{
    public function __invoke(Request $request)
    {
        $groups = CouncilGroup::active()->with('members')->get();

        return view('council.index', compact('groups'));
    }
}
