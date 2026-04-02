<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AgentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->is_agent) {
            return redirect('/agent/login')->with('error', 'Unauthorized');
        }

        return $next($request);
    }
}