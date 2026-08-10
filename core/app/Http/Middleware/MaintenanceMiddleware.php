<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MaintenanceMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (gs('maintenance_mode') == 1 && !auth()->guard('admin')->check()) {
            return redirect()->route('maintenance');
        }
        return $next($request);
    }
}
