<?php

namespace App\Http\Controllers;

use App\Models\EducationInstitution;
use Illuminate\Http\Request;

class EducationInstitutionController extends Controller
{
    public function index(Request $request)
    {
        $institutions = EducationInstitution::active()
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%'.$request->string('q').'%';
                $query->where(function ($query) use ($term) {
                    $query->where('name', 'like', $term)
                        ->orWhere('city', 'like', $term);
                });
            })
            ->when($request->filled('cidade'), fn ($query) => $query->where('city', $request->string('cidade')))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $cities = EducationInstitution::active()->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');

        return view('institutions.index', compact('institutions', 'cities'));
    }
}
