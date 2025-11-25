<?php

namespace App\Services;

use App\Models\Services;
use App\Models\TicketPrices;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCartData(): ?array
    {
        $cart = session('cart', [
            'tickets' => [],
            'services' => [],
        ]);

        $cart = session('cart_tickets', []);
        $cart_service = session('cart_service', []);

        if (empty($cart) && empty($cart_service)) {
            return null;
        }

        $ticketIds = array_keys($cart);
        $tickets = TicketPrices::whereIn('id', $ticketIds)->with('ticket')->get();

        $total_price = 0;
        $total_qty = 0;
        foreach ($tickets as $item) {
            $qty = $cart[$item->id]['quantity'] ?? 0;
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

        return [
            'cart'              => $cart,
            'tickets'           => $tickets,
            'total_qty'         => $total_qty,
            'total_price'       => $total_price,
            'cart_service'      => $cart_service,
            'servicesCart'      => $servicesCart,
            'total_priceService' => $total_priceService,
        ];
    }

    public function updateCart(int $ticketId, int $quantity): array
    {
        $cart = session('cart_tickets', []);

        if ($quantity > 0) {
            $cart[$ticketId] = [
                'ticket_id' => $ticketId,
                'quantity'  => $quantity,
            ];
        } else {
            unset($cart[$ticketId]);
        }

        session(['cart_tickets' => $cart]);

        if (empty($cart)) {
            return [
                'status'   => 'empty',
                'redirect' => url('/ticket-reguler/buy?date=' . now()->toDateString()),
                'error'    => 'Keranjang kosong! Silakan pilih tiket terlebih dahulu.',
            ];
        }

        $data = $this->getCartData();

        return [
            'status'        => 'success',
            'html_cart'     => view('frontend.page.partial.checkout_cart', [
                'cart' => $data['cart'],
                'tickets' => $data['tickets'],
                'total_qty' => array_sum(array_column($data['cart'], 'quantity')),
                'total_price' => $data['total_price'],
            ])->render(),
            'html_rincian'  => view('frontend.page.partial.details_payment', [
                'total_price' => $data['total_price'],
                'total_priceService' => $data['total_priceService'],
            ])->render(),
        ];
    }

    public function addServiceCart(int $service_id, int $quantity): array
    {
        $cart_service = session('cart_service', []);

        if ($quantity > 0) {
            $cart_service[$service_id] = [
                'service_id' => $service_id,
                'quantity'   => $quantity,
            ];
        } else {
            unset($cart_service[$service_id]);
        }

        session(['cart_service' => $cart_service]);

        $data = $this->getCartData();

        return [
            'message' => 'Layanan berhasil ditambahkan',
            'html_cart' => view('frontend.page.partial.service_cart', [
                'cart_service' => $data['cart_service'] ?? [],
                'servicesCart' => $data['servicesCart'] ?? [],
            ])->render(),

            'html_rincian' => view('frontend.page.partial.details_payment', [
                'total_price' => $data['total_price'],
                'total_priceService' => $data['total_priceService'],
            ])->render(),
        ];
    }

    public function deleteServiceById($serviceId)
    {
        $cart_service = session('cart_service', []);

        if (isset($cart_service[$serviceId])) {
            unset($cart_service[$serviceId]);
            session(['cart_service' => $cart_service]);
        }

        $data = $this->getCartData();

        return [
            'message' => 'Layanan dihapus!',
            'html_cart' => view('frontend.page.partial.service_cart', [
                'cart_service' => $data['cart_service'] ?? [],
                'servicesCart' => $data['servicesCart'] ?? [],
            ])->render(),

            'html_rincian' => view('frontend.page.partial.details_payment', [
                'total_price' => $data['total_price'],
                'total_priceService' => $data['total_priceService'],
            ])->render(),
        ];
    }

    public function delete_cartservice(): void
    {
        Session::forget('cart_service');
        Log::info('Cart service setelah dihapus:', [session('cart_service')]);
    }
}
