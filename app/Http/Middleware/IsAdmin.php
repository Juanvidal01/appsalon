<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        abort_if(!auth()->check() || !auth()->user()->admin, 403);
        return $next($request);
    }
}
