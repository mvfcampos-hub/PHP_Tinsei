<?php

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (! function_exists('setting')) {
    /** Lê um valor de "Configurações do site" (painel administrativo). */
    function setting(string $key, mixed $default = null): mixed
    {
        return SiteSetting::get($key, $default);
    }
}

if (! function_exists('media_url')) {
    /**
     * URL pública de uma imagem: aceita URLs absolutas, caminhos de
     * public/ (ex.: "/images/site/x.jpg") ou arquivos enviados pelo painel
     * (disco "public").
     */
    function media_url(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        if (Str::startsWith($path, '/')) {
            return asset(ltrim($path, '/'));
        }

        return Storage::disk('public')->url($path);
    }
}

if (! function_exists('youtube_id')) {
    function youtube_id(?string $url): ?string
    {
        if (blank($url)) {
            return null;
        }

        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/))([A-Za-z0-9_-]{11})~', $url, $m)) {
            return $m[1];
        }

        return null;
    }
}

if (! function_exists('initials')) {
    function initials(?string $name): string
    {
        $parts = collect(preg_split('/\s+/', trim((string) $name)))
            ->reject(fn ($p) => in_array(Str::lower($p), ['de', 'da', 'do', 'dos', 'das', 'e'], true))
            ->values();

        if ($parts->isEmpty()) {
            return '?';
        }

        $first = Str::substr($parts->first(), 0, 1);
        $last = $parts->count() > 1 ? Str::substr($parts->last(), 0, 1) : '';

        return Str::upper($first.$last);
    }
}

if (! function_exists('whatsapp_url')) {
    function whatsapp_url(?string $message = null, ?string $number = null): string
    {
        $number = preg_replace('/\D/', '', $number ?? (string) setting('whatsapp'));

        return 'https://wa.me/'.$number.($message ? '?text='.rawurlencode($message) : '');
    }
}

if (! function_exists('br_number')) {
    function br_number(int|float|null $value): string
    {
        return number_format((float) $value, 0, ',', '.');
    }
}
