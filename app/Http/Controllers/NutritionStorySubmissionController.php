<?php

namespace App\Http\Controllers;

use App\Models\NutritionStory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NutritionStorySubmissionController extends Controller
{
    public function create()
    {
        $areas = NutritionStory::AREAS;

        return view('nutrition-stories.suggest', compact('areas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'area' => ['required', 'string', 'in:'.implode(',', NutritionStory::AREAS)],
            'region' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'summary' => ['required', 'string', 'max:500'],
            'body' => ['required', 'string', 'max:5000'],
            'submitter_name' => ['required', 'string', 'max:255'],
            'submitter_email' => ['required', 'email', 'max:255'],
        ]);

        NutritionStory::create([
            ...$data,
            'slug' => Str::slug($data['title']).'-'.Str::lower(Str::random(6)),
            'status' => 'pending',
            'is_active' => false,
        ]);

        return redirect()
            ->route('nutrition-stories.index')
            ->with('suggested', true);
    }
}
