<?php

namespace App\Services;

use App\Models\Orders;
use Illuminate\Support\Carbon;

class HistoryService
{

    public function getServishistory(string $phone)
    {
        $today = Carbon::today();

        $data = Orders::with('transaction', 'customer', 'items.tiket.category_ticket')
            ->whereHas('customer', function ($query) use ($phone) {
                $query->where('phone', $phone);
            })
            ->whereDate('created_at', $today)
            ->latest()
            ->get();

        return $data;
    }

    public function getDetailhistory($id)
    {
        $order = Orders::with('customer','transaction','items.tiket.category_ticket', 'serviceItem')->findOrFail($id);

        $total_tiket    = 0;

        foreach ($order->items as $item) {
            $total_tiket += $item->qty;
        }
        // dd($total_tiket);

        return [
            'order'     => $order,
            'total'     => $total_tiket
        ];
    }
}
