<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Symfony\Component\HttpFoundation\Response;

class AzanypayKeyMiddleware
{
    use HttpResponses;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-APAY-Key');

        if ($apiKey !== config('app.azanypay_key')) {
            return $this->errorResponse('Unauthorized access', [], 401);
        }

        return $next($request);
    }
}
