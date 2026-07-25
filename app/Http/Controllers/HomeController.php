<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\EventItem;
use App\Models\Inspector;
use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('home', [
            'heroBanners' => Banner::active()->placement('home_hero')->get(),
            'secondaryBanners' => Banner::active()->placement('home_secondary')->get(),
            'featuredNews' => News::published()->where('is_featured', true)->latest('published_at')->take(3)->get(),
            'latestNews' => News::published()->latest('published_at')->take(4)->get(),
            'upcomingEvents' => EventItem::upcoming()->take(4)->get(),
            'stats' => [
                'fiscais' => Inspector::active()->count(),
                'unidades' => Inspector::active()->pluck('region')->unique()->count(),
                'noticias' => News::published()->count(),
            ],
        ]);
    }
}
