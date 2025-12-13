<?php
use Illuminate\Support\Facades\Cache;
use App\Models\CategoryPlaces;

if (! function_exists('kategori_jelajah')) {
    function kategori_jelajah() {
        return Cache::remember('kategori_jelajah', 3600, function () {
            return CategoryPlaces::select('id','name','slug')->with('place')->get();
        });
    }
}
