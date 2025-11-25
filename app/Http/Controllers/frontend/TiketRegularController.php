<?php

namespace App\Http\Controllers\frontend;

use App\Models\TicketPrices;
use Illuminate\Http\Request;
use App\Services\TiketService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class TiketRegularController extends Controller
{

    protected TiketService $tiketService;

    public function __construct(TiketService $tiketService)
    {
        $this->tiketService = $tiketService;
    }

    public function index(Request $request)
    {

        $oldDate = session('visit_date');
        $newDate = $request->query('date', now()->toDateString());

        if ($request->has('date')) {
            $newDate = $request->query('date');
            $oldDate = session('visit_date');

            if ($oldDate && $oldDate !== $newDate) {
                Session::forget('cart_tickets');
                Session::flash('warning', 'Tanggal kunjungan diubah — keranjang dikosongkan.');
            }

            Session::put('visit_date', $newDate);

        } else {
            $date = session('visit_date', now()->toDateString());
            return redirect()->route('tiket.checkout', ['date' => $date]);
        }

        session(['visit_date' => $newDate]);

        $cart = session('cart_tickets', []);
        $jumlah_tiket = array_sum(array_column($cart, 'quantity'));

        $result = $this->tiketService->cekTiket($newDate);
        
        $images = $this->tiketService->image();


        return view('frontend.page.buyTicketRegular', [
            'title'         => 'Checkout || Waterboom Jogja',
            'date'          => $result['date'],
            'category'      => $result['category'],
            'tickets'       => $result['tickets'],
            'images'       => $images, 
            'keranjang'     => $cart,
            'jumlah_tiket'  => $jumlah_tiket,
        ]);
    }

    public function get_By_date(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
        ]);

        $result = $this->tiketService->cekTiket($validated['date']);

        if ($request->ajax()) {
            return view('frontend.page.partial.ticket-list', [
                'tickets'  => $result['tickets'],
                'date'     => $result['date'],
                'category' => $result['category'],
            ])->render();
        }

        return redirect()->route('tiket.checkout', ['date' => $validated['date']]);
    }

    public function createCart(Request $request)
    {
        $request->validate([
            'ticket_id'     => 'required|integer|exists:ticket_prices,id',
            'quantity'      => 'required|integer'
        ]);

        $ticketId = (int) $request->input('ticket_id');
        $quantity = max(0, (int) $request->input('quantity'));

        $result = $this->tiketService->updateCart($ticketId, $quantity);

        return response()->json([
            'message' => 'Cart diperbarui.',
            'html' => $result['html'],
        ]);
    }

    public function getCart()
    {
        $cart = session('cart_tickets', []);

        if (empty($cart)) {
            $html = view('frontend.page.partial.cart-list', ['cart' => [], 'tickets' => collect([])])->render();
            return response()->json(['html' => $html]);
        }

        $totals = $this->tiketService->hitungTotal($cart);

        $html = view('frontend.page.partial.cart-list', [
            'cart'      => $cart,
            'tickets'   => $totals['tickets'],
            'total'     => $totals['total_price'],
        ])->render();

        return response()->json(['html' => $html]);
    }

    public function destroyCartTiket()
    {

        $this->tiketService->clearCart();

        return redirect('/ticket-reguler/buy?date=' . now()->toDateString())
            ->with('success', 'Tiket dihapus!');
    }

    public function clearCart1()
    {
        session()->forget('cart_tickets');

        return response()->json(['success' => true]);
    }
}
