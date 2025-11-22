<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthKeyMiddleware
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
        $headerName = $this->repository->get('security.header_key');
        $expectedValue = $this->repository->get('security.header_value');

        $receivedValue = $request->header($headerName);

        if (! $receivedValue) {
            return $this->responseFactory->json(['error' => 'Unauthorized access. Missing required header.'], 401);
        }

        if ($receivedValue !== $expectedValue) {
            return $this->responseFactory->json(['error' => 'Unauthorized access. Invalid header value.'], 401);
        }

        return $next($request);
    }
}
