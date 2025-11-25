<!DOCTYPE html>
<html>

<head>
    <title>Print Order {{ $order_detail->order_code }}</title>

    @vite(['resources/css/app.css'])
</head>

<body onload="window.print()" class="p-10 bg-white text-gray-700">
    <div class="max-w-4xl mx-auto mb-5">
        <div class="flex justify-between items-center mb-2">
            <div class="flex gap-3">
                <img src="{{ asset('img/logo-base.png') }}" class="w-14" alt="">
                <div>
                    <h1 class="text-base text-end font-bold">LAPORAN PEMBELIAN TIKET</h1>
                    <h1 class="text-base font-bold text-blue-700">DEVISI TIKETING</h1>
                </div>
            </div>
            <div>
                <img src="{{ asset('img/QR-Code.png') }}" class="w-16" alt="">
                <span class="text-xs"><i>scan-code</i></span>
            </div>
        </div>
        <hr>
    </div>
    <div class="max-w-4xl mx-auto mt-3 mb-3">
        <h1 class="text-xs text-right">Pemesanan : {{ format_tanggal_jam($order_detail->created_at) }} </h1>
    </div>
    <div class="max-w-4xl mx-auto mb-5 text-sm">
        <div class="flex justify-between">
            <div class="w-full rounded-md ">
                <h1 class="font-semibold mb-3">Informasi Pemesanan</h1>
                <div class="flex justify-between text-xs mb-1">
                    <h1>Kode Pemesanan</h1>
                    <h1 class="font-semibold">{{ $order_detail->order_code }}</h1>
                </div>
                <div class="flex justify-between text-xs mb-1">
                    <h1>Tanggal Pemesanan</h1>
                    <h1 class="font-semibold">{{ format_tanggal($order_detail->order_date) }}</h1>
                </div>
                <div class="flex justify-between text-xs mb-1">
                    <h1>Status Pembayaran</h1>
                    <h1 class="font-semibold">Rp{{ number_format($order_detail->gross, 0, ',', '.') }}</h1>
                </div>
                <div class="flex justify-between text-xs mb-1 items-center">
                    <h1>Total Pembayaran</h1>
                    <h1 class="font-semibold text-xs">
                        @if ($order_detail->payment_status == 'paid')
                            <span
                                class="border px-2 py- text-xs border-green-500 text-green-500  rounded-md">Lunas</span>
                        @elseif($order_detail->payment_status == 'pending')
                            <span class="border px-2 py-1 border-blue-600 text-blue-600  rounded-md">Menunggu</span>
                        @elseif($order_detail->payment_status == 'unpaid')
                            <span class="border px-2 py-1 border-yellow-500 text-yellow-500  rounded-md">Belum
                                Bayar</span>
                        @else
                            <span class="border px-2 py-1 border-red-600 text-red-600 rounded-md">Gagal</span>
                        @endif
                    </h1>
                </div>
            </div>
            <div class="w-52">
            </div>
            <div class="w-full">
                <h1 class="font-semibold mb-3">Informasi Customer</h1>
                <div class="flex justify-between text-xs mb-1">
                    <h1>Nama</h1>
                    <h1 class="font-semibold">{{ $order_detail->customer->name }}</h1>
                </div>
                <div class="flex justify-between text-xs mb-1">
                    <h1>Email</h1>
                    <h1 class="font-semibold">{{ $order_detail->customer->email }}</h1>
                </div>
                <div class="flex justify-between text-xs mb-1">
                    <h1>No Handphone</h1>
                    <h1 class="font-semibold">{{ $order_detail->customer->phone }}</h1>
                </div>
                <div class="flex justify-between text-xs mb-1 items-center">
                    <h1>Alamat</h1>
                    <h1 class="font-semibold text-xs">
                        {{ $order_detail->customer->address }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-4xl mx-auto mb-5">
        <h3 class="text-sm font-semibold mb-2">Item Pesanan Tiket</h3>
        <table class="w-full border border-gray-300 text-xs">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-2 py-1">No</th>
                    <th class="border px-2 py-1">Item</th>
                    <th class="border px-2 py-1">Qty</th>
                    <th class="border px-2 py-1">Harga</th>
                    <th class="border px-2 py-1">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order_detail->items as $item)
                    <tr>
                        <td class="border px-2 py-1 text-center">{{ $loop->iteration }}</td>
                        <td class="border px-2 py-1">{{ $item->tiket->ticket_name }} - <span
                                class="text-xs text-gray-400">{{ $item->category_ticket->name }}</span></td>
                        <td class="border px-2 py-1 text-center">{{ $item->qty }}</td>
                        <td class="border px-2 py-1 text-center">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="border px-2 py-1 text-center">
                            Rp{{ number_format($item->qty * $item->price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right px-2 py-1 ">PPN</td>
                    <td class="text-center px-2 py-1 font-semibold border">Rp.500</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right px-2 py-1 ">Total Pembayaran</td>
                    <td class="text-center px-2 py-1 font-semibold border">
                        Rp{{ number_format($order_detail->gross, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

    </div>
    <div class="max-w-4xl mx-auto mb-5">
        <h3 class="text-sm font-semibold mb-2">Item Pesanan Service</h3>
        <table class="w-full border border-gray-300 text-xs">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-2 py-1">No</th>
                    <th class="border px-2 py-1">Item</th>
                    <th class="border px-2 py-1">Qty</th>
                    <th class="border px-2 py-1">Harga</th>
                    <th class="border px-2 py-1">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order_service as $item)
                    <tr>
                        <td class="border px-2 py-1 text-center">{{ $loop->iteration }}</td>
                        <td class="border px-2 py-1">{{ $item->service->name }}</td>
                        <td class="border px-2 py-1 text-center">{{ $item->qty_service }}</td>
                        <td class="border px-2 py-1 text-center">Rp{{ number_format($item->price_service) }}</td>
                        <td class="border px-2 py-1 text-center">
                            Rp{{ number_format($item->qty_service * $item->price_service) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right px-2 py-1 ">Total Pembayaran</td>
                    <td class="text-center px-2 py-1 font-semibold border">
                        Rp{{ number_format($total_service, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="max-w-4xl mx-auto mb-5">
        <div class="flex justify-between gap-20">
            <div class="w-96 border rounded-md shadow-md">
                <div class="flex justify-center items-center">
                    <img src="{{ asset('img/QR-Code.png') }}" class="w-60" alt="">
                </div>
            </div>
            <div class="w-full text-gray-700 ">
                <h3 class="text-base font-bold  mb-2">Pembayaran - <span
                        class="text-blue-700">{{ $order_detail->order_code }}</span> </h3>
                <div class="border rounded-md p-2 mb-2">
                    <h1 class="px-3 pt-2 text-sm font-semibold">Informasi Pembayaran :</h1>
                    <div class="flex justify-between gap-2 mb-3 px-3">
                        <div class=" text-xs pt-2 mb-1">
                            <h1 class="">Batas</h1>
                            <h1 class="font-semibold">{{ format_tanggal_jam($order_detail->transaction->expiry_time ?? '-') }}
                            </h1>
                        </div>
                        <div class=" text-xs pt-2 mb-1">
                            <h1 class="">Diterima</h1>
                            <h1 class="font-semibold">
                                {{ format_tanggal_jam($order_detail->transaction->transaction_time ?? '-') }}
                        </div>
                    </div>
                    <div class="flex justify-between text-xs pt-2 px-3 mb-1">
                        <h1 class="">Metode Pembayaran</h1>
                        <h1 class="border  px-3 rounded-md font-semibold">
                            {{ $order_detail->transaction->payment_type ?? '-' }}</h1>
                    </div>
                    <div class="flex justify-between text-xs py-1 px-3 mb-1">
                        <h1 class="">Status Transaksi</h1>
                        <h1 class="  font-semibold">{{ $order_detail->transaction->transaction_status ?? '-' }}</h1>
                    </div>
                </div>
                <div class="p-2">
                    <div class="flex justify-between text-sm font-bold px-3 mb-1">
                        <h1 class="">Total Pembayaran</h1>
                        <h1 class=" font-semibold">Rp{{number_format($order_detail->transaction->gross_amount ?? '0') }}</h1>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</body>

</html>
