<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Services\HistoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HistoryUserController extends Controller
{
    protected $historyService;

    public function __construct(HistoryService $historyService)
    {
        $this->historyService = $historyService;
    }

    public function index()
    {

        $phone = session('phone');

        if (!$phone) {
            return view('frontend.page.historyUser', [
                'title'   => 'Riwayat || Waterboom Jogja',
                'history' => collect(),
            ]);
        }

        $history = $this->historyService->getServishistory($phone);

        return view('frontend.page.historyUser', [
            'title'     => 'Riwayat || Waterboom jogja',
            'history'   => $history,
        ]);
    }
    public function filterHistory(Request $request)
    {
        $phone  = session('phone');

        $request->validate([
            'status' => 'nullable|string|in:all,paid,unpaid,expired',
        ]);

        $status = $request->get('status', 'all');

        $query = Orders::with(['transaction', 'customer', 'items.tiket.category_ticket'])
            ->whereHas('customer', fn($q) => $q->where('phone', $phone));

        if ($status !== 'all') {
            $query->where('payment_status', $status);
        }

        $history = $query->latest()->get();

        return view('frontend.page.partial.history_list', compact('history'))->render();
    }

    public function historyDetail(Request $request, $id)
    {
        $request->merge(['id' => $id]);

        $request->validate([
            'id'        => 'required|integer|exists:orders,id'
        ]);

        $id = $request->input('id');

        $data = $this->historyService->getDetailhistory($id);

        return view('frontend.page.historyUserDetail', [
            'title'         => 'Detail || Waterboom Jogja',
            'order'         => $data['order'],
            'total_tiket'   => $data['total']
        ]);
    }

    public function destroy_phone()
    {
        if (empty(session('phone'))) {
            return redirect()->back()->with('error', 'Tidak ada data tersimpan!');
        } else {
            session()->forget('phone');
            return redirect()->back()->with('success', 'Berhasil keluar.');
        }
    }
}
