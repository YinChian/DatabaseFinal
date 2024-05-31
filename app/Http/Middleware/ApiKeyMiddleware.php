<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('ApiKeyMiddleware is running.');

        $apiKey = $request->header('API-KEY');

        if ($apiKey !== env('API_KEY')) {
            Log::warning('Unauthorized access attempt with API key: ' . $apiKey);
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
