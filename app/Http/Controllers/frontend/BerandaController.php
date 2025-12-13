<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BerandaService;

class BerandaController extends Controller
{
    protected $berandaService;

    public function __construct(BerandaService $berandaService)
    {
        $this->berandaService = $berandaService;
    }

    public function index()
    {

        $data = $this->berandaService->getData();

        return view('frontend.page.beranda', [
            'title'             => 'Beranda || Waterboom-Jogja',
            'berita'            => $data['berita'],
            'slider'            => $data['slider'],
            'jelajah'           => $data['jelajah'],
            'event'             => $data['event'],
            'promo'             => $data['promo'],
            'penghargaan'       => $data['penghargaan'],
            'partner'           => $data['partner']
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:1|max:100'
        ]);

        $key = trim(strip_tags($request->q));

        if ($key === '') {
            return response()->json(['error' => 'Kata kunci tidak boleh kosong'], 422);
        }

        $result = $this->berandaService->getPencarian($key);

        return response()->json([
            'place' => $result['place'] ?? [],
            'blog'  => $result['blog'] ?? [],
            'promo' => $result['promo'] ?? [],
        ]);
    }
}
