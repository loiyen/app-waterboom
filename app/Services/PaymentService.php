<?php

namespace App\Services;

use App\Models\Orders;
use App\Models\Services;
use App\Models\Customers;
use Illuminate\Support\Str;
use App\Models\TicketPrices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{

    public function getData(string $name, string $phone, string $email, string $address)
    {
        session()->put('phone', $phone);

        $customer = Customers::firstOrCreate(
            ['phone' => $phone],
            [
                'name'    => $name,
                'email'   => $email,
                'address' => $address
            ]
        );

        $order_cek = Orders::with('transaction')
            ->where('customer_id', $customer->id)
            ->where('payment_status', 'unpaid')
            ->latest()
            ->first();

        if ($order_cek) {
            
            return redirect(route('history.buy'))
                ->with('error', 'Anda sudah memiliki pesanan yang belum dibayar.');
        }

        $cart_ticket = session('cart_tickets', []);
        $cart_service = session('cart_service', []);

        if (empty($cart_ticket) && empty($cart_service)) {
            return redirect('/tiket-reguler/checkout?date=' . now()->toDateString())
                ->with('error', 'Keranjang anda kosong, pilih tiket terlebih dahulu.');
        }

        $category_id  = session('category_id');
        $date = session('visit_date');

        $ticketIds = array_keys($cart_ticket);
        $tickets = TicketPrices::whereIn('id', $ticketIds)->with('ticket')->get();

        $total_price = 0;
        $total_qty = 0;
        foreach ($tickets as $item) {
            $qty = $cart_ticket[$item->id]['quantity'] ?? 0;
            $total_price += $item->price * $qty;
            $total_qty += $qty;
        }

        $serviceIds = array_keys($cart_service);
        $servicesCart = Services::whereIn('id', $serviceIds)->get();

        $total_priceService = 0;
        foreach ($servicesCart as $item) {
            $qty = $cart_service[$item->id]['quantity'] ?? 0;
            $total_priceService += $item->price * $qty;
        }

        $grandtotal = $total_price + $total_priceService + 500;

        DB::beginTransaction();

        try {

            $externalId = 'ORD-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(5));

            $order = Orders::create([
                'customer_id'    => $customer->id,
                'order_code'     => $externalId,
                'order_date'     => $date,
                'payment_status' => 'unpaid',
                'gross'          => $grandtotal,
            ]);

            foreach ($tickets as $item) {
                $qty = $cart_ticket[$item->id]['quantity'] ?? 0;

                $order->items()->create([
                    'order_id'    => $order->id,
                    'ticket_id'   => $item->ticket_id,
                    'category_id' => $category_id,
                    'qty'         => $qty,
                    'price'       => $item->price,
                ]);
            }

            foreach ($servicesCart as $item) {

                $qty = $cart_service[$item->id]['quantity'] ?? 0;

                $order->serviceItem()->create([
                    'order_id'       => $order->id,
                    'service_id'     => $item->id,
                    'qty_service'    => $qty,
                    'price_service'  => $item->price,
                ]);
            }

            $transaction = app(XenditService::class)->createQrisTransaction($order);

            if (!$transaction || empty($transaction->invoice_url)) {
                throw new \Exception('Gagal membuat transaksi Xendit.');
            }

            DB::commit();

            session()->put('phone', $phone);
            return $transaction;
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal membuat pesanan', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
