<?php

namespace App\Http\Controllers;

use App\Models\EventItem;

class EventController extends Controller
{
    public function index()
    {
        $upcomingEvents = EventItem::upcoming()->get();
        $pastEvents = EventItem::where('starts_at', '<', now())->orderByDesc('starts_at')->take(10)->get();

        return view('events.index', compact('upcomingEvents', 'pastEvents'));
    }
}
