<!DOCTYPE html>
<html>

<head>
    <title>Print Order #</title>

    @vite(['resources/css/app.css'])
</head>

<body onload="window.print()" class="p-10 bg-white text-gray-700">
    <div class="max-w-4xl mx-auto text-center mb-10">
        <div class="flex justify-between items-center mb-2">
            <img src="{{ asset('img/logo-base.png') }}" class="w-14" alt="">
            <div>
                <h1 class="text-2xl font-bold">LAPORAN PEMBELIAN TIKET</h1>
                <h1 class="text-2xl font-bold text-blue-700">DEVISI TIKETING</h1>
            </div>
            <h1 class=""></h1>
        </div>
    </div>
    <div class="max-w-4xl mx-auto">
        <table class="w-full border border-gray-300 text-sm">
            <thead class="text-sm">
                <tr class="bg-gray-100">
                    <th class="border px-2 py-3">No</th>
                    <th class="border px-2 py-3">Customer</th>
                    <th class="border px-2 py-3">Kode Pemesanan</th>
                    <th class="border px-2 py-3">Tanggal Pemesanan</th>
                    <th class="border px-2 py-3">Status Pembayaran</th>
                    <th class="border px-2 py-3">Total Pembayaran</th>
                    <th class="border px-2 py-3">Dibuat</th>
                </tr>
            </thead>

            <tbody class="text-xs">
                @foreach ($data as $item)
                    <tr>
                        <td class="border px-2 py-3 text-center">{{ $loop->iteration }}</td>
                        <td class="border px-2 py-3">{{ $item->customer->name }}</td>
                        <td class="border px-2 py-3">{{ $item->order_code }}</td>
                        <td class="border px-2 py-3 text-center">{{ format_tanggal($item->order_date) }}</td>
                        <td class="border px-2 py-3 text-center">
                            @if ($item->payment_status == 'paid')
                                <span
                                    class="border px-2 py-1 border-green-500 text-green-500  rounded-md">Lunas</span>
                            @elseif($item->payment_status == 'pending')
                                <span class="border px-2 py-1 border-blue-600 text-blue-600  rounded-md">Menunggu</span>
                            @elseif($item->payment_status == 'unpaid')
                                <span class="border px-2 py-1 border-yellow-500 text-yellow-500  rounded-md">Belum
                                    Bayar</span>
                            @else
                                <span class="border px-2 py-1 border-red-600 text-red-600 rounded-md">Gagal</span>
                            @endif
                        </td>
                        <td class="border px-2 py-3 text-center">Rp{{ number_format($item->gross, 0, ',', '.') }}</td>
                        <td class="border px-2 py-3 text-center">{{ format_tanggal($item->created_at) }}</td>
                    </tr>
                @endforeach
                <tr class="border-2 text-xs font-semibold">
                    <td></td>
                    <td></td>
                    <td class=" text-center px-2 py-3">Lunas  : {{ $paid }} </td>
                    <td class=" text-center px-2 py-3">Menunggu  : {{ $pending }} </td>
                    <td class=" text-center px-2 py-3">Belum Bayar  : {{ $unpaid }} </td>
                    <td class=" text-center px-2 py-3">Kadarluasa  : {{ $expired }} </td>
                </tr>
                <tr class="border-2 text-xs font-semibold">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class=" text-right px-2 py-3">Total  </td>
                    <td class=" text-right px-2 py-3">Rp.{{number_format($total)  }}</td>
                </tr>
                <tr class="border-2 text-xs font-semibold">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="  px-2 py-3 text-right">Total Pembayaran </td>
                    <td class="  px-2 py-3 text-right">Rp.{{number_format($total_bersih)  }}</td>
                </tr>
            </tbody>
        </table>

        <div class="mt-4 text-right">
            {{-- <h3 class="text-lg font-bold">
                Total Bayar: Rp {{ number_format($order->total) }}
            </h3> --}}
        </div>

    </div>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</body>

</html>
