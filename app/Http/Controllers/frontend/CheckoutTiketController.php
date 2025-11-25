<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Services;
use App\Services\CartService;
use Illuminate\Http\Request;

class CheckoutTiketController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $data = $this->cartService->getCartData();

        if (!$data) {
            return redirect('/ticket-reguler/buy?date=' . now()->toDateString())
                ->with('kosong', 'Keranjang kosong! Pilih tiket anda');
        }

        $servicesAll = Services::where('is_active', 1)->get();

        return view('frontend.page.buyCheckoutTicket', [
            'title'                 => 'Checkout || Waterboom Jogja',
            'cart'                  => $data['cart'],
            'tickets'               => $data['tickets'],
            'date'                  => session('visit_date'),
            'ticket_category'       => session('ticket_category'),
            'total_qty'             => $data['total_qty'],
            'total_price'           => $data['total_price'],
            'cart_service'          => $data['cart_service'],
            'servicesCart'          => $data['servicesCart'],
            'total_priceService'    => $data['total_priceService'],
            'servicesAll'           => $servicesAll,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'ticket_id'     => 'required|integer|exists:ticket_prices,id',
            'quantity'      => 'required|integer|min:0|max:15'
        ]);

        $ticketId = (int) $request->input('ticket_id');
        $quantity = max(0, (int) $request->input('quantity'));

        $result = $this->cartService->updateCart($ticketId, $quantity);

        if ($result['status'] === 'empty') {
            return response()->json([
                'redirect' => $result['redirect'],
                'error'    => $result['error'],
            ], 400);
        }

        return response()->json([
            'message'      => 'Keranjang diperbarui.',
            'html_cart'    => $result['html_cart'],
            'html_rincian' => $result['html_rincian'],
        ]);
    }

    public function addService(Request $request)
    {
        $request->validate([
            'service_id' => 'required|integer|exists:services,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $service_id = (int) $request->input('service_id');
        $quantity = (int) $request->input('quantity');

        $service = Services::find($service_id);
        if (!$service || $service->is_active != 1) {
            return response()->json([
                'error' => 'Layanan tidak tersedia atau sudah non-aktif.',
            ], 400);
        }

        $cart = session('cart_service', []);
        if (isset($cart[$service_id])) {
            return response()->json([
                'error' => 'Layanan ini sudah ada di keranjang.',
            ], 400);
        }

        $data_service = $this->cartService->addServiceCart($service_id, $quantity);

        return response()->json([
            'message'      => $data_service['message'],
            'html_cart'    => $data_service['html_cart'],
            'html_rincian' => $data_service['html_rincian'],
        ]);
    }

    public function destroyService($id)
    {
        $result = $this->cartService->deleteServiceById($id);

        return response()->json([
            'message'      => $result['message'],
            'html_cart'    => $result['html_cart'],
            'html_rincian' => $result['html_rincian'],
        ]);
    }

    public function destroyCartService()
    {
        $this->cartService->delete_cartservice();

        return response()->json(['message' => 'Semua layanan berhasil dihapus!']);
    }
}
