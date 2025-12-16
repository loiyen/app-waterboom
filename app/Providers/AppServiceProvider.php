<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use App\Models\CategoryPlaces;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Assets\Js; // penting!
use Filament\Support\Facades\FilamentAsset;

use App\Filament\Responses\CustomLoginResponse;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }


        Paginator::useTailwind();

        $this->app->bind(LoginResponse::class, CustomLoginResponse::class);
    }
}
