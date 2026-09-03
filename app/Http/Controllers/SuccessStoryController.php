<?php

namespace App\Http\Controllers;

use App\Models\SuccessStory;

class SuccessStoryController extends Controller
{
    public function __invoke()
    {
        return view('success-stories.index', [
            'stories' => SuccessStory::active()->get(),
        ]);
    }
}
