<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Partner;
use App\Models\PortfolioCategory;
use App\Models\Testimonial;
use App\Models\TimelineEvent;
use App\Support\ClientMap;

class InstitutionalController extends Controller
{
    public function about()
    {
        return view('institutional.about', [
            'timeline' => TimelineEvent::active()->get(),
            'partners' => Partner::active()->get(),
            'map' => ClientMap::build(),
        ]);
    }

    public function portfolio()
    {
        return view('institutional.portfolio', [
            'categories' => PortfolioCategory::active()->get(),
            'brands' => Brand::active()->get(),
        ]);
    }

    public function sustainability()
    {
        return view('institutional.sustainability');
    }

    public function presence()
    {
        return view('institutional.presence', ['map' => ClientMap::build()]);
    }

    public function testimonials()
    {
        return view('institutional.testimonials', [
            'testimonials' => Testimonial::active()->get(),
        ]);
    }
}
