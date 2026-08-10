<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckKycMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!gs('kv')) {
            return $next($request);
        }
        $user = auth()->user();
        if ($user->kv != 1) {
            $notify[] = ['warning', 'You need to complete KYC verification first.'];
            return redirect()->route('user.kyc')->withNotify($notify);
        }
        return $next($request);
    }
}
