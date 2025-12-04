<?php

namespace App\Services;

use App\Models\CategoryPlaces;
use App\Models\Events;
use App\Models\Galleries;
use App\Models\News;
use App\Models\Places;
use App\Models\Promos;

class BerandaService
{
    public function getData()
    {
        $news = News::with('user')->where('is_active', 1)
            ->inRandomOrder()

            ->limit(3)
            ->get();

        $slider = Galleries::where('category', 'slider')->where('is_active', 1)->get();

        $partner = Galleries::where('category', 'partner')->where('is_active', 1)->get();

        $reward = Galleries::where('category', 'Penghargaan dan Prestasi')
            ->where('is_active', 1)->get();

        $place = Places::with('categoryplace')
            ->inRandomOrder()
            ->limit(5)
            ->get();

        $event = Events::where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $promo = Promos::where('is_active', 1)
            ->limit(5)
            ->orderBy('created_at', 'desc')
            ->get();

        $category_jelajah = CategoryPlaces::with('place')->get();

        return [
            'berita'            => $news,
            'slider'            => $slider,
            'jelajah'           => $place,
            'event'             => $event,
            'penghargaan'       => $reward,
            'partner'           => $partner,
            'promo'             => $promo,
            'category_jelajah'  => $category_jelajah
        ];
    }

    public function getPencarian($key)
    {

        $place = Places::with('categoryplace')->where('name', 'like', "%{$key}%")->get();
        $blog  = News::where('title', 'like', "%{$key}%")->get();
        $promo = Promos::where('title', 'like', "%{$key}%")->get();

        return [
            'place' => $place,
            'blog'  => $blog,
            'promo' => $promo
        ];
    }
}
