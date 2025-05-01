<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-Key'); 

        if (!$apiKey || !ApiKey::where('key', $apiKey)->exists()) { // jika key ada maka return 1, jika tidak ada return 0
            return response()->json(['error' => 'Unauthorized'], 401); // 0
        }

        return $next($request); //1
    }
}
