<?php

namespace App\Services;

use App\Models\Categorynews;
use App\Models\News;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

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

        $categories = CategoryNews::with([
            'news' => function ($q) {
                $q->where('is_active', 1)
                    ->latest()
                    ->limit(3);
            }
        ])->get();

        return [
            'berita'             => $news,
            'news_other'         => $news_other,
            'berita_slider'      => $news_slider,
            'category_berita'    => $categories
        ];
    }

    public function getdetailbycategory(string $slug)
    {
        $category = Categorynews::where('slug', $slug)->first();

        if (!$category) {
            return collect();
        }

        return $category->news()
            ->where('is_active', 1)
            ->latest()
            ->paginate(6);
    }


    public function getDetail($slug)
    {
        $news_other = News::with('user')
            ->where('is_active', 1)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $data_detail = News::with('user')
            ->where('slug', $slug)
            ->where('is_active', 1)
            ->first();

        if (!$data_detail) {
            return null;
        }

        return [
            'detail'      => $data_detail,
            'news_other'  => $news_other,
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
