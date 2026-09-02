<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Client;
use App\Models\CloudPlan;
use App\Models\EventItem;
use App\Models\News;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $ecosystemHub = Product::active()->where('slug', 'dataclassic')->first();

        return view('home', [
            'heroBanners' => Banner::active()->placement('home_hero')->get(),
            'noticeBanners' => Banner::active()->placement('home_notice')->get(),
            'secondaryBanners' => Banner::active()->placement('home_secondary')->get(),
            'featuredProducts' => Product::active()->featured()->get(),
            'ecosystemHub' => $ecosystemHub,
            'ecosystemSatellites' => $ecosystemHub
                ? Product::active()->where('id', '!=', $ecosystemHub->id)->get()
                : collect(),
            'cloudProduct' => Product::active()->where('is_cloud_highlight', true)->first(),
            'cloudPlans' => CloudPlan::active()->take(3)->get(),
            'featuredNews' => News::published()->where('is_featured', true)->latest('published_at')->take(3)->get(),
            'latestNews' => News::published()->latest('published_at')->take(4)->get(),
            'upcomingEvents' => EventItem::upcoming()->take(4)->get(),
            'testimonials' => Testimonial::active()->get(),
            'clients' => Client::active()->type('cliente')->get(),
            'partners' => Client::active()->type('parceiro')->get(),
        ]);
    }
}
