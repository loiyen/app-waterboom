<?php

namespace App\Http\Controllers\frontend;

use App\Models\Orders;
use App\Models\TicketPrices;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Services\XenditService;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PaymentTiketRegular extends Controller
{

    protected $paymentService;
    protected $cartService;
    protected $xenditService;

    public function __construct(PaymentService $paymentService, CartService $cartService, XenditService $xenditService)
    {
        $this->paymentService = $paymentService;
        $this->cartService = $cartService;
        $this->xenditService = $xenditService;
    }

    public function index()
    {
        $cart = session('cart_tickets', []);

        if (empty($cart)) {
            return redirect('/tiket-reguler/checkout?date=' . now()->toDateString())
                ->with('error', 'Gagal! Pilih tiket anda!');
        }

        $detail_pembayaran = $this->cartService->getCartData();

        return view('frontend.page.buyTicketPaymentRegular', [
            'title'                 => 'Pembayaran || Waterboom jogja',
            'total_qty'             => $detail_pembayaran['total_qty'],
            'total_price'           => $detail_pembayaran['total_price'],
            'cart_service'          => $detail_pembayaran['cart_service'],
            'servicesCart'          => $detail_pembayaran['servicesCart'],
            'total_priceService'    => $detail_pembayaran['total_priceService'],
        ]);
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'name'      => 'required|string',
            'phone'     => 'required|string',
            'email'     => 'required|string',
            'address'   => 'required|string',
            'metode'    => 'required',
            'approv'    => 'required',
        ]);

        $transaction = $this->paymentService->getData(
            $request->name,
            $request->phone,
            $request->email,
            $request->address,
            $request->metode
        );

        if ($transaction instanceof \Illuminate\Http\RedirectResponse) {
            return $transaction;
        }

        if (empty($transaction->invoice_url)) {
            Log::error('Transaksi Xendit tidak mengembalikan invoice_url', ['transaction' => $transaction]);
            return back()->with('error', 'Gagal membuat invoice pembayaran.');
        }

        return redirect($transaction->invoice_url);
    }

    public function pay(Request $request, Orders $order)
    {
        try {
            if (!in_array($order->payment_status, ['unpaid', 'pending'])) {
                return back()->with('error', 'Pesanan ini sudah dibayar atau tidak bisa dibayar ulang.');
            }

            $transaction = $this->xenditService->createQrisTransaction($order);

            return redirect($transaction->invoice_url);
        } catch (\Throwable $e) {
            Log::error('Payment retry failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal membuat ulang pembayaran. Silakan coba lagi.');
        }
    }

    public function success(Request $request)
    {
        session()->forget(['cart_tickets', 'cart_service', 'visit_date', 'ticket_category']);

        return redirect(route('history.buy'))->with('success', 'Pemesanan tiket berhasil');
    }

    public function failed(Request $request)
    {
        session()->forget(['cart_tickets', 'cart_service']);

        return redirect(route('history.buy'))->with('error', 'Pemesanan gagal');
    }
}
