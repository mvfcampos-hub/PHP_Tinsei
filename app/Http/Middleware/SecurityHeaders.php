<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Adds baseline security response headers appropriate for a public
     * institutional/government site: clickjacking protection, MIME-sniffing
     * protection, a same-origin-only Content-Security-Policy (with the
     * minimal allowances the app actually needs — Google Fonts, Alpine.js's
     * function-constructor-based expression evaluation, and the DataSac
     * webchat widget), and HSTS once the request is actually being served
     * over HTTPS.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=(), usb=()');

        $response->headers->set('Content-Security-Policy', implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'unsafe-eval' https://app.datasac.com.br",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
            "font-src 'self' https://fonts.gstatic.com https://app.datasac.com.br",
            "img-src 'self' data: https://app.datasac.com.br",
            "connect-src 'self' https://app.datasac.com.br wss://app.datasac.com.br",
            "frame-src https:",
            "frame-ancestors 'self'",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
        ]));

        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
