<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Services\BlogService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Services\TfidfService;

class BlogController extends Controller
{

    protected $blogService;

    public function __construct(BlogService $blogService,)
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

    public function detail($slug, TfidfService $tfidfService)
    {
        try {
            $data = $this->blogService->getDetail($slug);

            // Berita saat ini (object)
            $currentNews = $data['detail'];
            $currentId   = $currentNews->id;

            // Ambil semua berita kecuali berita saat ini
            $allNews = News::where('id', '!=', $currentId)->get();

            // Ambil isi konten semua berita
            $documents = $allNews->pluck('content')->toArray();

            // Hitung TF-IDF semua dokumen
            $tfidfDocs = $tfidfService->compute($documents);

            // Hitung TF-IDF untuk berita saat ini
            $currentTfidf = $tfidfService->compute([$currentNews->content])[0];

            // Hitung similarity
            $similarity = [];
            foreach ($tfidfDocs as $index => $vec) {
                $similarity[$index] = $tfidfService->cosineSimilarity($currentTfidf, $vec);
            }

            // Urutkan berdasarkan kemiripan dari paling tinggi
            arsort($similarity);

            // Ambil 5 berita teratas sebagai rekomendasi
            $related = collect($similarity)
                ->take(5)
                ->map(function ($score, $index) use ($allNews) {
                    return [
                        'news'  => $allNews[$index],
                        'score' => $score
                    ];
                });

            return view('frontend.page.blogPageDetail', [
                'title'         => 'Detail || Waterboom Jogja',
                'berita'        => $currentNews,
                'berita_lain'   => $data['news_other'],  // original
                'related_news'  => $related,             // rekomendasi TF-IDF
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal memuat detail blog: ' . $e->getMessage());
            abort(404, 'Berita tidak ditemukan');
        }
    }


    public function search(Request $request)
    {
        $validated = $request->validate([
            'q' => 'nullable|string'
        ]);

       
        if (empty($validated['q'])) {

            $berita = News::orderBy('created_at', 'desc')->paginate(8);

            return view('frontend.page.partial.blog_list', [
                'berita' => $berita
            ])->render();
        }

        try {
            $berita = $this->blogService->getPencarian($validated['q']);

            return view('frontend.page.partial.blog_list', [
                'berita' => $berita
            ])->render();
        } catch (\Exception $e) {
            Log::error('Filter Blog Error: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memuat data'], 500);
        }
    }
}
