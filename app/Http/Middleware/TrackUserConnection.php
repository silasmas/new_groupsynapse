<?php

namespace App\Http\Middleware;

use App\Models\ConnectionLog;
use App\Services\IpLocationService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackUserConnection
{
    private const MAX_PAGES = 50;

    public function __construct(
        protected IpLocationService $ipLocation
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->user() && $request->hasSession()) {
            $context = str_contains($request->path(), 'admin') ? 'dashboard' : 'site';
            $sessionId = $request->session()->getId();
            $currentUrl = '/' . ltrim($request->path(), '/');

            $log = ConnectionLog::firstOrNew([
                'user_id' => $request->user()->getKey(),
                'session_id' => $sessionId,
            ]);

            $wasCreated = !$log->exists;
            $log->ip_address = $request->ip();
            $log->user_agent = $request->userAgent();
            $log->context = $context;
            $log->last_activity_at = now();

            if ($wasCreated) {
                $log->country = $this->ipLocation->getCountry($request->ip());
            }

            $pages = $log->pages_visited ?? [];
            if (!in_array($currentUrl, $pages)) {
                $pages[] = $currentUrl;
                $log->pages_visited = array_slice($pages, -self::MAX_PAGES);
            }

            $log->save();
        }

        return $response;
    }
}
