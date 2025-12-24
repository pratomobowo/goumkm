<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->is_super_admin && !auth()->user()->tenant_id) {
            return redirect()->route('tenant.setup');
        }

        return $next($request);
    }
}
