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
            'title'                    => 'Blog || Waterboom Jogja',
            'berita'                   => $data['berita'],
            'berita_lain'               => $data['news_other'],
            'berita_slider'             => $data['berita_slider'],
            'berita_category'           => $data['category_berita']
        ]);
    }

    public function detail($slug, TfidfService $tfidfService)
    {
        $data = $this->blogService->getDetail($slug);

        if (!$data || empty($data['detail'])) {
            abort(404, 'Berita tidak ditemukan');
        }

        $currentNews = $data['detail'];
        $currentId   = $currentNews->id;

        $allNews = News::where('id', '!=', $currentId)
            ->where('is_active', 1)
            ->whereNotNull('content')
            ->get();

        $related = collect();

        if ($allNews->count() > 0 && !empty($currentNews->content)) {
            try {
                $documents     = $allNews->pluck('content')->toArray();
                $tfidfDocs     = $tfidfService->compute($documents);
                $currentTfidf  = $tfidfService->compute([$currentNews->content])[0];

                $similarity = [];
                foreach ($tfidfDocs as $index => $vec) {
                    $similarity[$index] =
                        $tfidfService->cosineSimilarity($currentTfidf, $vec);
                }

                arsort($similarity);

                $related = collect($similarity)
                    ->take(5)
                    ->map(fn($score, $index) => [
                        'news'  => $allNews[$index],
                        'score' => $score
                    ]);
            } catch (\Throwable $e) {
                Log::warning('TF-IDF gagal', ['error' => $e->getMessage()]);
            }
        }

        return view('frontend.page.blogPageDetail', [
            'title'         => 'Detail || Waterboom Jogja',
            'berita'        => $currentNews,
            'berita_lain'   => $data['news_other'],
            'related_news'  => $related,
        ]);
    }


    public function detail_by_category($slug)
    {
        $data       = $this->blogService->getdetailbycategory($slug);

        return view('frontend.page.blogCategoryPage', [
            'title'                  => $slug,
            'data_category'          => $data
        ]);
    }


    public function search(Request $request)
    {
        $q = $request->validate([
            'q' => 'nullable|string|max:100'
        ])['q'] ?? null;

        $q = strip_tags($q);

        try {
            $berita = empty($q)
                ? News::orderByDesc('created_at')->paginate(8)
                : $this->blogService->getPencarian($q);

            return response(
                view('frontend.page.partial.blog_list', compact('berita'))->render()
            )
                ->header('Cache-Control', 'no-store')
                ->header('X-Content-Type-Options', 'nosniff');
        } catch (\Throwable $e) {
            Log::error('Filter Blog Error', ['error' => $e->getMessage()]);
            return response('', 500);
        }
    }
}
