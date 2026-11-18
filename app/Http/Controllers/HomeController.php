<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\EventItem;
use App\Models\News;
use App\Models\Partner;
use App\Models\PortfolioCategory;
use App\Models\Testimonial;
use App\Models\TimelineEvent;
use App\Support\ClientMap;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('home', [
            'heroBanners' => Banner::active()->placement('home_hero')->get(),
            'campaignBanners' => Banner::active()->placement('home_campaign')->get(),
            'categories' => PortfolioCategory::active()->get(),
            'brands' => Brand::active()->get(),
            'map' => ClientMap::build(),
            'timeline' => TimelineEvent::active()->get(),
            'partners' => Partner::active()->get(),
            'testimonials' => Testimonial::active()->take(6)->get(),
            'latestNews' => News::published()->orderByDesc('is_featured')->latest('published_at')->take(3)->get(),
            'upcomingEvents' => EventItem::upcoming()->take(3)->get(),
        ]);
    }
}
