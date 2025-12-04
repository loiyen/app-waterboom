<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Js; // penting!

use App\Models\CategoryPlaces;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;

use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use App\Filament\Responses\CustomLoginResponse;



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

        $kategori_jelajah = Cache::remember('kategori_jelajah', 3600, function () {
            return CategoryPlaces::select('id', 'name', 'slug')->with('place')->get();
        });

        // dd($kategori_jelajah);

        View::share('kategori_jelajah', $kategori_jelajah);

        Paginator::useTailwind();

        $this->app->bind(LoginResponse::class, CustomLoginResponse::class);

        
    }
}
