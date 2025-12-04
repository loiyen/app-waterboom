<?php

namespace App\Services;

use App\Models\CategoryPlaces;
use App\Models\Galleries;
use App\Models\Places;
use Illuminate\Support\Facades\Request;

class JelajahService
{

    public function getDataCategory(string $slug)
    {

        $data_category = CategoryPlaces::where('slug', $slug)->firstOrFail();

        $data_banner = Galleries::where('category', 'checkout')->get();

        $place  = Places::with('categoryplace')->where('category_place_id', $data_category->id)->paginate(8);

        $total  = Places::where('category_place_id', $data_category->id)->count();

        return [
            'kategori'      => $data_category,
            'place'         => $place,
            'total'         => $total,
            'banner'        => $data_banner
        ];
    }

    public function getDetailPlace($slug)
    {
        $data = Places::with('categoryplace')->where('slug', $slug)->firstOrFail();

        return [
            'place' => $data
        ];
    }

    // public function getSearch(string $slug, ?string $query = null)
    // {
    //     $category = CategoryPlaces::where('slug', $slug)->firstOrFail();

    //     $places = $category->place()
    //         ->when($query, function ($q) use ($query) {
    //             $q->where('name', 'like', "%{$query}%");
    //         })
    //         ->latest()
    //         ->paginate(6);

    //     return [
    //         'category' => $category,
    //         'places'   => $places,
    //     ];
    // }

    public function getSearch(string $slug, ?string $query = null, int $page = 1)
    {
        $category = CategoryPlaces::where('slug', $slug)->firstOrFail();

        $places = $category->place()
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->latest()
            ->paginate(8, ['*'], 'page', $page); // support page

        return [
            'category' => $category,
            'places'   => $places,
        ];
    }
}
