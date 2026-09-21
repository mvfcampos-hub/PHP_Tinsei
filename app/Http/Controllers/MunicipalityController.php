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
            ->paginate(60)
            ->withQueryString();

        $totalProfessionals = MunicipalityProfessionalCount::sum('total_count');
        $totalMunicipalities = MunicipalityProfessionalCount::count();
        $referenceDate = MunicipalityProfessionalCount::max('reference_date');

        return view('municipalities.index', compact('counts', 'totalProfessionals', 'totalMunicipalities', 'referenceDate'));
    }
}
