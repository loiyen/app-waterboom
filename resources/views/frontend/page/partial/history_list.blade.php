@forelse ($history as $item)
    <div class="border rounded-md mb-5">
        <div class="">
            @if ($item->payment_status == 'unpaid')
                <h1 class="mt-4 mb-4 px-3 text-sm text-center font-semibold text-gray-700"> <i
                        class="fa fa-check-square text-gray-700"></i> Belum Bayar!</h1>
            @elseif($item->payment_status == 'pending')
                <h1 class="mt-4 mb-4 px-3 text-sm text-center font-semibold text-yellow-600"> <i class="fa fa-clock "></i>
                    Menunggu Pembayaran!</h1>
            @elseif($item->payment_status == 'paid')
                <h1 class="mt-4 mb-4 px-3 text-sm text-center font-semibold text-green-700"> <i
                        class="fa fa-check-square "></i> Berhasil!</h1>
            @else
                <h1 class="mt-3 mb-3 px-3 text-sm text-center font-semibold text-red-700"> <i
                        class="fa fa-check-square"></i> Transaksi gagal!</h1>
            @endif
        </div>
        <hr>
        <div class="mb-2">
            <div class="flex justify-between text-xs md:text-sm mt-3 px-3">
                <h1 class="text-gray-600">Kode Pemesanan </h1>
                <h1 class="font-semibold text-gray-700">{{ $item->order_code }}</h1>
            </div>
            <div class="flex justify-between text-xs md:text-sm py-2 px-3">
                <h1 class="text-gray-600">Tanggal Pemesanan </h1>
                <h1 class="font-semibold text-gray-700">{{ format_tanggal($item->order_date) }}</h1>
            </div>
        </div>
        <hr>
        <div class="flex justify-between text-xs md:text-sm py-2 px-3">
            <div>
                <h1 class="font-semibold text-gray-700 ">Total</h1>
                <h1 class="font-semibold text-blue-700">Rp{{ number_format($item->gross) }}</h1>
            </div>
            @if ($item && in_array($item->payment_status, ['paid', 'pending', 'expired']))
                <a href="{{ route('history.detail', $item->id) }}"
                    class="border py-2 px-6 rounded-md bg-blue-700 text-white hover:bg-blue-800 font-semibold">Lihat</a>
            @elseif ($item && $item->transaction && $item->transaction->invoice_url)
                <a href="{{ $item->transaction->invoice_url }}"
                    class="border py-2 px-6 rounded-md bg-blue-700 text-white hover:bg-blue-800">Bayar</a>
            @else
                <span class="text-gray-500">Tidak ada data transaksi</span>
            @endif
        </div>
    </div>
@empty
    <div class="rounded-md p-16">
        <div class="flex justify-center ">
            <img src="{{ asset('img/notfon.png') }}" class="object-cover w-20 h-20" alt="">
        </div>
        <h1 class="text-center py-3 text-xs font-semibold text-gray-500">Tidak di temukan!</h1>

    </div>
@endforelse
