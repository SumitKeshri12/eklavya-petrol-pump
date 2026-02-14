<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HostVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Define allowed hosts
        $allowedHosts = [
            'localhost',
            '127.0.0.1',
            'eklavya-petrol-pump-production.up.railway.app',
            '192.168.5.64',
        ];

        // Add APP_URL host to allowed list
        $appUrl = config('app.url');
        if ($appUrl) {
            $parsedAppUrl = parse_url($appUrl);
            if (isset($parsedAppUrl['host'])) {
                $allowedHosts[] = $parsedAppUrl['host'];
            }
        }

        // Get the incoming request host (proxy-aware)
        $requestHost = $request->getHost();

        // Check if the request host is in the allowed list
        if (! in_array($requestHost, $allowedHosts)) {
            abort(403, 'Forbidden: Host header mismatch');
        }

        return $next($request);
    }
}
