<?php

namespace App\Http\Controllers;

use App\Models\EventItem;

class EventController extends Controller
{
    public function index()
    {
        return view('events.index', [
            'upcomingEvents' => EventItem::upcoming()->get(),
            'pastEvents' => EventItem::past()->take(12)->get(),
        ]);
    }
}
