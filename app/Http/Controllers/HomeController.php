<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Client;
use App\Models\ClientPresence;
use App\Models\EventItem;
use App\Models\News;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $ecosystemHub = Product::active()->systems()->where('slug', 'dataclassic')->first();

        return view('home', [
            'heroBanners' => Banner::active()->placement('home_hero')->get(),
            'noticeBanners' => Banner::active()->placement('home_notice')->get(),
            // Somente soluções de sistemas (ERP, mobilidade, atendimento, fiscal,
            // CRM, comunicação, integrações) — Cloud tem destaque próprio; Serviços
            // de TI e Produtos (hardware) têm páginas dedicadas fora do catálogo.
            'featuredProducts' => Product::active()->systems()->featured()->get(),
            'ecosystemHub' => $ecosystemHub,
            'ecosystemSatellites' => Product::active()->ecosystemNode()->get(),
            'featuredNews' => News::published()->where('is_featured', true)->latest('published_at')->take(4)->get(),
            'latestNews' => News::published()->latest('published_at')->take(4)->get(),
            'upcomingEvents' => EventItem::upcoming()->take(4)->get(),
            'testimonials' => Testimonial::active()->get(),
            'clients' => Client::active()->type('cliente')->get(),
            'partners' => Client::active()->type('parceiro')->get(),
            'presenceStates' => ClientPresence::active()->type(ClientPresence::TYPE_STATE)->get(),
            'presenceCountries' => ClientPresence::active()->type(ClientPresence::TYPE_COUNTRY)->get(),
        ]);
    }
}
