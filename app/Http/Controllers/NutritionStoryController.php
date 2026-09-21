<?php

namespace App\Http\Controllers;

use App\Models\MunicipalityProfessionalCount;
use App\Models\NutritionStory;
use Illuminate\Http\Request;

class NutritionStoryController extends Controller
{
    public function index(Request $request)
    {
        $stories = NutritionStory::published()
            ->when($request->filled('area'), fn ($query) => $query->where('area', $request->string('area')))
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->paginate(9)
            ->withQueryString();

        $areas = NutritionStory::AREAS;

        $stats = [
            'nutricionistas' => MunicipalityProfessionalCount::sum('nutritionists_count'),
            'municipios' => MunicipalityProfessionalCount::count(),
            'areas' => NutritionStory::published()->distinct('area')->count('area'),
        ];

        return view('nutrition-stories.index', compact('stories', 'areas', 'stats'));
    }

    public function show(NutritionStory $story)
    {
        abort_unless($story->is_active && $story->status === 'published', 404);

        $related = NutritionStory::published()
            ->where('area', $story->area)
            ->where('id', '!=', $story->id)
            ->take(3)
            ->get();

        return view('nutrition-stories.show', compact('story', 'related'));
    }
}
