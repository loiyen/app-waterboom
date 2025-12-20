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
            'status' => 'nullable|in:all,tiket,resto',
            'search' => 'nullable|string|max:100',
        ]);

        $status = $validated['status'] ?? 'all';
        $search = strip_tags(trim($validated['search'] ?? ''));

        try {
            $data = $this->promoService->getPromos($status, $search);

            if ($request->ajax()) {
                return response(
                    view('frontend.page.partial.promo_list', [
                        'promos' => $data['promos'],
                    ])->render()
                )
                    ->header('Cache-Control', 'no-store')
                    ->header('X-Content-Type-Options', 'nosniff');
            }

            return view('frontend.page.promoPage', [
                'title'           => 'Promo || Waterboom Jogja',
                'promos'          => $data['promos'],
                'countByCategory' => $data['countByCategory'],
                'totalAll'        => $data['totalAll'],
                'status'          => $data['status'],
                'totalFiltered'   => $data['promos']->total(),
                'banner'          => $data['banner'],
            ]);
        } catch (\Throwable $e) {
            Log::error('Promo filter error', ['error' => $e->getMessage()]);
            abort(500);
        }
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
