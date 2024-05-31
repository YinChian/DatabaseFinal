<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JsonMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // 確保請求的 Content-Type 是 application/json
        if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('patch')) {
            if (!$request->isJson()) {
                return response()->json(['error' => 'Content-Type must be application/json'], 415);
            }
        }

        // 處理請求
        $response = $next($request);

        // 確保響應是 JSON 格式
        if (!$response->headers->contains('Content-Type', 'application/json')) {
            $response->headers->set('Content-Type', 'application/json');
        }

        return $response;
    }
}
