<?php

namespace App\Services;

use App\Models\Promos;
use Illuminate\Support\Facades\DB;

class PromoService
{
    public function getPromos($status = 'all', $search = '', $perPage = 8)
    {
        $query = Promos::query();

        if ($status !== 'all') {
            $query->whereRaw('LOWER(category) = ?', [strtolower($status)]);
        }
        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        $promos = $query->latest()->paginate($perPage);

        $countByCategory = Promos::select(
            DB::raw('LOWER(category) as category'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy(DB::raw('LOWER(category)'))
            ->pluck('total', 'category')
            ->toArray();



        $totalAll = array_sum($countByCategory);

        // Total sesuai kategori aktif
        $totalFiltered = $status === 'all'
            ? $totalAll
            : ($countByCategory[strtolower($status)] ?? 0);

        return [
            'promos' => $promos,
            'countByCategory' => $countByCategory,
            'totalAll' => $totalAll,
            'totalFiltered' => $totalFiltered,
            'status' => $status,
        ];
    }

    public function detail($slug)
    {
        $promo = Promos::where('slug', $slug)->firstOrFail();
        $promo_all = Promos::inRandomOrder()->limit(3)->get();

        return [
            'detail' => $promo,
            'promo_lain' => $promo_all,
        ];
    }
}
