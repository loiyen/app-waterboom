<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Orderitemservices;
use App\Models\Orders;
use Illuminate\Http\Request;

class ReportPrintController extends Controller
{
    public function print_order(Request $request)
    {
        $filters = $request->all();

        $query = Orders::query()->with('customer');

        if (!empty($filters['from'])) {
            $query->whereDate('created_at', '>=', $filters['from']);
        }

        if (!empty($filters['until'])) {
            $query->whereDate('created_at', '<=', $filters['until']);
        }

        if (!empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }


        $totalPembayaran = (clone $query)->sum('gross');
        $total_bersih   = (clone $query)->where('payment_status', 'paid')->sum('gross');
        $total_paid      = (clone $query)->where('payment_status', 'paid')->count();
        $total_expired   = (clone $query)->where('payment_status', 'expired')->count();
        $total_unpaid    = (clone $query)->where('payment_status', 'unpaid')->count();
        $total_pending   = (clone $query)->where('payment_status', 'pending')->count();


        return view('backend.report.print_order', [
            'data'              => $query->get(),
            'total'             => $totalPembayaran,
            'total_bersih'      => $total_bersih,
            'paid'              => $total_paid,
            'unpaid'            => $total_unpaid,
            'expired'           => $total_expired,
            'pending'           => $total_pending,
        ]);
    }


    public function print_order_by_id($id)
    {
        $order_by_id = Orders::with('customer', 'items', 'serviceItem', 'transaction')->findOrFail($id);

        $order_service = Orderitemservices::with('order', 'service')
            ->where('orders_id', $id)
            ->get();

        $total_service = 0;

        foreach($order_service as $item )
        {
            $total_service += $item->qty_service * $item->price_service;
        }

        return view('backend.report.print_order_byID', [
            'order_detail'          => $order_by_id,
            'order_service'         => $order_service,
            'total_service'         => $total_service
        ]);
    }
}
