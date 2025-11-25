<?php

namespace App\Services;

use App\Models\Galleries;
use App\Models\Holidays;
use App\Models\TicketCategories;
use App\Models\TicketPrices;
use Illuminate\Support\Facades\Session;

class TiketService
{

    public function cekTiket(string $date): array
    {
        Session::put('visit_date', $date);

        $category = $this->determinateCategory($date);
        Session::put('ticket_category', $category);

        $tickets = TicketPrices::with(['ticket', 'ticket_category'])
            ->whereHas('ticket_category', fn($q) => $q->where('name', $category))
            ->where('star_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->get() ?? collect([]);

        return [
            'date'              => $date,
            'category'          => $category,
            'tickets'           => $tickets,
        ];
    }

    public function determinateCategory(string $date): string
    {
        $category = 'other';
        $categoryId = null;

        $holiday = Holidays::whereDate('date', $date)->first();

        if ($holiday) {
            $category = 'Holiday';
        } else {
            $dayOfWeek = date('N', strtotime($date));

            $category = match (true) {
                $dayOfWeek >= 1 && $dayOfWeek <= 5 => 'Weekday',
                $dayOfWeek == 6 || $dayOfWeek == 7 => 'Weekend',
                default => 'other',
            };
        }

        $categoryId = TicketCategories::where('name', $category)->value('id');

        Session::put('ticket_category', $category);
        Session::put('category_id', $categoryId);

        return $category;
    }

    public function updateCart(int $ticketId, int $quantity): array
    {
        $cart = Session::get('cart_tickets', []);

        if ($quantity > 0) {
            $cart[$ticketId] = [
                'ticket_id' => $ticketId,
                'quantity'  => $quantity,
            ];
        } else {
            unset($cart[$ticketId]);
        }

        Session::put('cart_tickets', $cart);

        $tickets = $this->getTicketsFromCart($cart);
        $html = view('frontend.page.partial.cart-list', compact('cart', 'tickets'))->render();

        return [
            'cart' => $cart,
            'tickets' => $tickets,
            'html' => $html,
        ];
    }

    /**
     * Ambil semua tiket berdasarkan session cart
     */
    public function getTicketsFromCart(array $cart)
    {
        $ticketIds = array_keys($cart);

        return TicketPrices::whereIn('id', $ticketIds)
            ->with('ticket')
            ->get();
    }

    public function hitungTotal(array $cart): array
    {
        $tickets = $this->getTicketsFromCart($cart);
        $total_price = 0;
        $total_qty = 0;

        foreach ($tickets as $ticket) {
            $qty = $cart[$ticket->id]['quantity'] ?? 0;
            $total_price += $ticket->price * $qty;
            $total_qty += $qty;
        }

        return [
            'tickets' => $tickets,
            'total_price' => $total_price,
            'total_qty' => $total_qty,
        ];
    }

    public function image()
    {
        return Galleries::where('category', 'tiket')
            ->where('is_active', 1)
            ->first();
    }

    public function clearCart(): void
    {
        Session::forget('cart_tickets');
    }
}
