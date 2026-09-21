<?php

namespace App\Services;

use App\Models\EventItem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Sabre\VObject\Reader;

class CfnCalendarSync
{
    private const FEED_URL = 'https://calendario.cfn.org.br/eventos/?ical=1';

    /**
     * @return array{created: int, updated: int, total: int}
     */
    public function sync(): array
    {
        $response = Http::timeout(20)->get(self::FEED_URL);
        $response->throw();

        $vcalendar = Reader::read($response->body());

        $created = 0;
        $updated = 0;

        foreach ($vcalendar->VEVENT as $vevent) {
            $uid = (string) $vevent->UID;
            $title = (string) $vevent->SUMMARY;
            $startsAt = $vevent->DTSTART->getDateTime();
            $endsAt = isset($vevent->DTEND) ? $vevent->DTEND->getDateTime() : null;
            $location = isset($vevent->LOCATION) ? (string) $vevent->LOCATION : null;
            $description = isset($vevent->DESCRIPTION) && (string) $vevent->DESCRIPTION !== ''
                ? (string) $vevent->DESCRIPTION
                : null;
            $url = isset($vevent->URL) ? (string) $vevent->URL : null;

            $existing = EventItem::where('external_uid', $uid)->first();

            $attributes = [
                'title' => $title,
                'description' => $description,
                'location' => $location,
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'external_url' => $url,
                'source' => 'cfn_sync',
            ];

            if ($existing) {
                $existing->update($attributes);
                $updated++;
            } else {
                EventItem::create($attributes + [
                    'slug' => $this->uniqueSlug($title, $startsAt->format('Y-m-d')),
                    'external_uid' => $uid,
                    'is_featured' => false,
                ]);
                $created++;
            }
        }

        return ['created' => $created, 'updated' => $updated, 'total' => $created + $updated];
    }

    private function uniqueSlug(string $title, string $date): string
    {
        $base = Str::slug($title.'-'.$date);
        $slug = $base;
        $suffix = 1;

        while (EventItem::where('slug', $slug)->exists()) {
            $slug = $base.'-'.(++$suffix);
        }

        return $slug;
    }
}
