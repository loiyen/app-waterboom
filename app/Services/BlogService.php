<?php

namespace App\Services;

use App\Models\News;

class BlogService
{

    public function getData()
    {
        $news = News::with('user')->where('is_active', 1)->paginate(8);

        $news_slider = News::with('user')->where('is_active', 1)
            ->inRandomOrder()
            ->limit(5)
            ->get();
        $news_other = News::with('user')->where('is_active', 1)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return [
            'berita'             => $news,
            'news_other'         => $news_other,
            'berita_slider'      => $news_slider
        ];
    }

    public function getDetail($slug)
    {
        $news_other = News::with('user')->where('is_active', 1)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        $data_detail     = News::with('user')->where('slug', $slug)->firstOrFail();

        return [
            'detail'                => $data_detail,
            'news_other'         => $news_other,
        ];
    }

    public function getPencarian($keyword)
    {
        return News::query()
            ->where('title', 'like', '%' . $keyword . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(8); // wajib paginate
    }
}
