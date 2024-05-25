<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class APIVersionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @return \Illuminate\Http\Response|RedirectResponse|JsonResponse|StreamedResponse
     */
    public function handle(Request $request, Closure $next, string $guard): Response|RedirectResponse|JsonResponse|StreamedResponse
    {
        config(['app.api.version' => $guard]);

        return $next($request);
    }
}
