<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UpdateLastLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guard('filament')->check()) {
            $user = auth()->guard('filament')->user();

           
            if (!session()->has('last_login_recorded')) {
                $user->forceFill([
                    'last_login_at' => now(),
                ])->save();

                session(['last_login_recorded' => true]);
            }
        }

        return $next($request);
    }
}
