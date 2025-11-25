<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Services\BlogService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{

    protected $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function index()
    {
        $data = $this->blogService->getData();

       

        return view('frontend.page.blogPage', [
            'title'                     => 'Blog || Waterboom Jogja',
            'berita'                   => $data['berita'],
            'berita_lain'               => $data['news_other'],
            'berita_slider'             => $data['berita_slider']
        ]);
    }

    public function detail($slug)
    {
        try {
            $data = $this->blogService->getDetail($slug);

            return view('frontend.page.blogPageDetail', [
                'title'                 => 'Detail || Waterboom Jogja',
                'berita'                => $data['detail'],
                'berita_lain'           => $data['news_other'],
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal memuat detail blog: ' . $e->getMessage());
            abort(404, 'Berita tidak ditemukan');
        }
    }

    // public function search(Request $request)
    // {
    //     $validated = $request->validate([
    //         'q' => 'nullable|string'
    //     ]);

    //     if (!$validated['q']) {
    //         return redirect()->route('blog.page'); // kembalikan ke halaman biasa
    //     }

    //     try {
    //         $berita = $this->blogService->getPencarian(
    //             $validated['q'] ?? '',
    //         );

    //         $data = $this->blogService->getData();

    //         return view('frontend.page.partial.blog_list', [
    //             'title'                     => 'Blog || Waterboom Jogja',
    //             'berita'                    => $berita,
    //             'berita_lain'               => $data['news_other'],
    //             'berita_slider'             => $data['berita_slider']
    //         ]);
    //     } catch (\Exception $e) {

    //         Log::error('Filter Promo Error: ' . $e->getMessage());
    //         return response()->json(['error' => 'Gagal memuat data'], 500);
    //     }
    // }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'q' => 'nullable|string'
        ]);

        if (!$validated['q']) {
            return redirect()->route('blog.page');
        }

        try {
            $berita = $this->blogService->getPencarian($validated['q']);

            return view('frontend.page.partial.blog_list', [
                'berita' => $berita
            ])->render();
        } catch (\Exception $e) {
            Log::error('Filter Promo Error: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memuat data'], 500);
        }
    }
}
