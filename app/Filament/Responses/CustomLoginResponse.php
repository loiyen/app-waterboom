<?php

namespace App\Filament\Responses;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = Auth::user();

        if ($user) {
            $user->forceFill([
                'last_login_at' => now(),
            ])->save();
        }

       
        return redirect()->intended(filament()->getHomeUrl());
    }
}
