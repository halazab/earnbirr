<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckStatusMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if ($user->status == 0) {
            auth()->logout();
            return redirect()->route('user.login')->withErrors(['Your account has been banned.']);
        }
        if (!$user->activation_fee_paid) {
            $routeName = $request->route()?->getName();
            if (in_array($routeName, ['user.tasks.index', 'user.tasks.my'])) {
                return $next($request);
            }
            return redirect()->route('user.activation');
        }
        return $next($request);
    }
}
