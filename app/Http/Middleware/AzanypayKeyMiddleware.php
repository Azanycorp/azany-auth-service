<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AzanypayKeyMiddleware
{
    use HttpResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-APAY-Key');

        if ($apiKey !== config('app.azanypay_key')) {
            return $this->error(null,'Unauthorized access', 401);
        }

        return $next($request);
    }
}
