<?php

namespace App\Http\Controllers\frontend;

use App\Models\Promos;
use Illuminate\Http\Request;
use App\Services\PromoService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PromoController extends Controller
{

    protected $promoService;

    public function __construct(PromoService $promoService)
    {
        $this->promoService = $promoService;
    }

    public function index(Request $request)
    {
        $validated = $request->validate([
            'status' => 'nullable|string',
            'search' => 'nullable|string',
        ]);

        $data = $this->promoService->getPromos(
            $validated['status'] ?? 'all',
            $validated['search'] ?? ''
        );

        if ($request->ajax()) {
            return view('frontend.page.partial.promo_list', [
                'promos' => $data['promos'],
            ])->render();
        }

        return view('frontend.page.promoPage', [
            'title' => 'Promo || Waterboom Jogja',
            'promos' => $data['promos'],
            'countByCategory' => $data['countByCategory'],
            'totalAll' => $data['totalAll'],
            'status' => $data['status'],
            'totalFiltered' => $data['promos']->total(),
            'banner'        => $data['banner']
        ]);
    }

    public function detailPromo($slug)
    {
        $promo = $this->promoService->detail($slug);

        return view('frontend.page.promoPageDetail', [
            'title'         => 'Promo || Waterboom Jogja',
            'promo'         => $promo['detail'],
            'promo_lain'    => $promo['promo_lain']
        ]);
    }
}
