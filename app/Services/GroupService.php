<?php

namespace App\Services;

use App\Models\Sales;

class GroupService
{
    public function getData()
    {
        $sales = Sales::where('is_active', 1)->paginate(8);

        return [
            'sales'         => $sales
        ];
    }

    public function getPencarian(?string $query)
    {

        return Sales::when($query, fn($qbuilder) => $qbuilder->where('name', 'like', "{$query}"))
            ->latest()
            ->paginate(8);
    }
}
