<?php

namespace App\Http\Controllers;

use App\Models\EventItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $upcomingEvents = EventItem::upcoming()->get();
        $pastEvents = EventItem::where('starts_at', '<', now())->orderByDesc('starts_at')->take(10)->get();

        $month = $request->filled('month')
            ? Carbon::createFromFormat('Y-m', (string) $request->query('month'))->startOfMonth()
            : now()->startOfMonth();

        $calendarWeeks = $this->buildCalendarWeeks($month);

        return view('events.index', compact('upcomingEvents', 'pastEvents', 'month', 'calendarWeeks'));
    }

    private function buildCalendarWeeks(Carbon $month): array
    {
        $gridStart = $month->copy()->startOfMonth()->startOfWeek(Carbon::SUNDAY);
        $gridEnd = $month->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        $events = EventItem::whereBetween('starts_at', [$gridStart->copy()->startOfDay(), $gridEnd->copy()->endOfDay()])
            ->orderBy('starts_at')
            ->get()
            ->groupBy(fn (EventItem $event) => $event->starts_at->format('Y-m-d'));

        $weeks = [];
        $cursor = $gridStart->copy();

        while ($cursor <= $gridEnd) {
            $week = [];

            for ($i = 0; $i < 7; $i++) {
                $week[] = [
                    'date' => $cursor->copy(),
                    'isCurrentMonth' => $cursor->month === $month->month,
                    'isToday' => $cursor->isToday(),
                    'events' => $events->get($cursor->format('Y-m-d'), collect()),
                ];
                $cursor->addDay();
            }

            $weeks[] = $week;
        }

        return $weeks;
    }
}
