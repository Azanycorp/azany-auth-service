<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MivKeyMiddleware
{
    use HttpResponse;
    public function __construct(private readonly \Illuminate\Contracts\Config\Repository $repository) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-MIV-Key');

        if ($apiKey !== $this->repository->get('app.miv_key')) {
            return $this->error(null, 'Unauthorized access', 401);
        }

        return $next($request);
    }
}
