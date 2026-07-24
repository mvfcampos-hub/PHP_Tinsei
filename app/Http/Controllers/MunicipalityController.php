<?php

namespace App\Http\Controllers;

use App\Models\MunicipalityProfessionalCount;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{
    public function __invoke(Request $request)
    {
        $counts = MunicipalityProfessionalCount::query()
            ->when($request->filled('municipio'), fn ($query) => $query->where('municipality', 'like', '%'.$request->string('municipio').'%'))
            ->orderBy('municipality')
            ->get();

        $totalProfessionals = $counts->sum('professionals_count');

        return view('municipalities.index', compact('counts', 'totalProfessionals'));
    }
}
