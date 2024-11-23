<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\IpUtils;
use Symfony\Component\HttpFoundation\Response;

class DevopsAccessFilter
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $passed = app()->environment(config('devops.access.allowed_environments'))
            || IpUtils::checkIp($request->ip(), config('devops.access.allowed_ips'))
            || (auth()->check() && in_array($request->user()->email, config('devops.access.allowed_users')));

        return $passed ? $next($request) : abort(403);
    }
}
