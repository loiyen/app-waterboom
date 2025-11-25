<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Services\JelajahService;
use App\Services\BerandaService;
use Illuminate\Http\Request;

class JelajahController extends Controller
{

    protected $jelajahService;


    public function __construct(JelajahService $jelajahService)
    {
        $this->jelajahService = $jelajahService;
    }

    public function index($slug)
    {

        $data = $this->jelajahService->getDataCategory($slug);

        return view('frontend.page.explorePage', [
            'title'     => 'Jelajah || Waterboom Jogja',
            'kategori'  => $data['kategori'],
            'places'    => $data['place'],
            'total'     => $data['total'],
        ]);
    }

    public function detaiPlace($slug)
    {

        $data_detail = $this->jelajahService->getDetailPlace($slug);

        $mediaItems = $data_detail['place']->getMedia('places-images')->shuffle();

        return view('frontend.page.explorePageDetail', [
            'title'             => 'Detail || Waterboom jogja',
            'detail_data'       => $data_detail['place'],
            'media_data'        => $mediaItems
        ]);
    }

    

    public function getsearch(Request $request, $slug)
    {
        $validated  = $request->validate([
            'q' => 'nullable|string',
        ]);

        $page  = $request->input('page', 1);
        try {
            $data = $this->jelajahService->getSearch($slug, $validated['q'], $page);

            return view('frontend.page.partial.explor_list', [
                'places' => $data['places'],
            ])->render();
        } catch (\Exception $e) {
            abort(404);
        }
    }
}
