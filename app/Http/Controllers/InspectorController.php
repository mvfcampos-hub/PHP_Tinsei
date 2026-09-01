<?php

namespace App\Http\Controllers;

use App\Models\Inspector;
use Illuminate\Http\Request;

class InspectorController extends Controller
{
    public function __invoke(Request $request)
    {
        $inspectors = Inspector::active()->get();

        $groupedInspectors = $inspectors->groupBy('region');

        $roleSummary = $inspectors
            ->groupBy('role')
            ->map(fn ($group) => $group->count())
            ->sortDesc();

        return view('inspectors.index', compact('groupedInspectors', 'roleSummary'));
    }
}
