<?php

namespace App\Services;

use App\Models\Galleries;
use App\Models\Sales;

class GroupService
{
    public function getData()
    {
        $sales = Sales::where('is_active', 1)->paginate(8);
        $data_banner = Galleries::where('category', 'group')->get();

        return [
            'sales'         => $sales,
            'banner'        => $data_banner
        ];
    }

    public function getPencarian(?string $query)
    {
        return Sales::when($query, fn($qbuilder) => $qbuilder->where('name', 'like', "{$query}"))
            ->latest()
            ->paginate(8);
    }
}
