<x-filament-panels::page>
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row gap-4 mb-5">
            <div class="w-full p-6 rounded-lg shadow">
                <h2 class="text-base font-bold mb-2">Informasi Pemesanan</h2>
                <div class="py-2 text-sm flex justify-between ">
                    <h1>Kode Pemesanan</h1>
                    <h1>{{ $record->order_code }}</h1>
                </div>
                <div class="py-2 text-sm flex justify-between ">
                    <h1>Tanggal Kedatangan</h1>
                    <h1>{{ format_tanggal($record->order_date) }}</h1>
                </div>
                <div class="py-2 text-sm flex justify-between ">
                    <h1>Pembayaran</h1>
                    <h1>{{ $record->payment_status }}</h1>
                </div>
                <div class="py-2 text-sm flex justify-between ">
                    <h1>Total</h1>
                    <h1>Rp{{ number_format($record->gross, 0, ',', '.') }}</h1>
                </div>
            </div>
            <div class="w-full p-6 rounded-lg shadow">
                <h2 class="text-base font-bold mb-2 ">Informasi Customer</h2>
                <div class="py-2  text-sm flex justify-between ">
                    <h1>Nama</h1>
                    <h1>{{ $record->customer?->name }}</h1>
                </div>
                <div class="py-2 text-sm flex justify-between ">
                    <h1>Email</h1>
                    <h1>{{ $record->customer?->email }}</h1>
                </div>
                <div class="py-2 flex text-sm justify-between ">
                    <h1>No Hanphone</h1>
                    <h1>{{ $record->customer?->phone }}</h1>
                </div>
                <div class="py-2 flex text-sm justify-between ">
                    <h1>Alamat</h1>
                    <h1>{{ $record->customer?->address }}</h1>
                </div>
            </div>
        </div>

        <div class="rounded-lg shadow mb-5">
            <div class="p-6">
                <h2 class="text-base font-bold mb-2">Informasi Tiket</h2>
                <table class="w-full text-sm ">
                    <thead class="">
                        <tr>
                            <th class=" p-2 text-left">Nama Tiket</th>
                            <th class=" p-2 text-right">Jumlah</th>
                            <th class=" p-2 text-right">Harga</th>
                            <th class=" p-2 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($record->items as $item)
                            @php
                                $qty = $item->qty;
                                $gross = $item->qty * $item->price;
                                $totalHarga = $record->items->sum(fn($item) => $item->price * $item->qty);
                            @endphp
                            <tr class="">
                                <td class="p-2 text-left">{{ $item->tiket->ticket_name }} - <i>(
                                        {{ $item->category_ticket->name }} )</i></td>
                                <td class="p-2 text-right">{{ $qty }}</td>
                                <td class="p-2 text-right">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="p-2 text-right">Rp{{ number_format($gross, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr class="">
                            <td class="p-2 text-left"></td>
                            <td class="p-2 text-left"></td>
                            <td class="p-2 text-right font-semibold">Total</td>
                            <td class="p-2 text-right font-semibold">Rp{{ number_format($totalHarga, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mb-5">
            <div class="flex  flex-col md:flex-row gap-3">
                <div class="p-6 rounded-lg shadow w-full h-auto">
                    <h2 class="text-base font-bold mb-2">Informasi Layanan Tambahan</h2>
                    <table class="w-full text-sm">
                        <thead class="">
                            <tr>
                                <th class=" p-2 text-left">Nama Layanan</th>
                                <th class=" p-2 text-right">Jumlah</th>
                                <th class=" p-2 text-right">Harga</th>
                                <th class=" p-2 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($record->serviceItem as $item)
                                @php

                                    $gross = $item->qty_service * $item->price_service;
                                    $totalHarga = $record->serviceItem->sum(
                                        fn($item) => $item->price_service * $item->qty_service,
                                    );
                                @endphp
                                <tr>
                                    <td class="p-2 text-left">{{ $item->service->name }}</td>
                                    <td class="p-2 text-right">{{ $item->qty_service }}</td>
                                    <td class="p-2 text-right">Rp{{ number_format($item->price_service, 0, ',', '.') }}
                                    </td>
                                    <td class="p-2 text-right">Rp{{ number_format($gross, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="p-2 text-left">
                                        Tidak ada layanan
                                    </td>
                                </tr>
                            @endforelse
                            <tr class="">
                                <td class="p-2 text-left"></td>
                                <td class="p-2 text-left"></td>
                                <td class="p-2 text-right font-semibold">Total</td>
                                <td class="p-2 text-right font-semibold">Rp{{ number_format($totalHarga) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="p-6 rounded-lg shadow w-1/2 h-auto">
                    <h2 class="text-base font-bold mb-2">Informasi Pembayaran</h2>
                    <div class="flex justify-between text-sm py-2">
                        <h1>Metode Pembayaran</h1>
                        <h1>{{ $record->transaction->payment_type }}</h1>
                    </div>
                    <div class="flex justify-between text-sm py-2">
                        <h1>Status Transaksi</h1>
                        <h1>{{ $record->transaction->transaction_status }}</h1>
                    </div>
                    <div class="flex justify-between text-sm py-2 font-semibold">
                        <h1>Total</h1>
                        <h1>Rp{{ number_format($record->transaction->gross_amount, 0, ',', '.') }}</h1>
                    </div>
                    <h1 class="text-sm py-2 font-semibold">Informasi lainnya </h1>
                    <div class="flex justify-between text-sm py-2">
                        <div>
                            <h1>Batas Pembayaran</h1>
                            <h1>{{ format_tanggal($record->transaction->expiry_time) }}</h1>
                        </div>
                        <div class="">
                            <h1>Pembayaran Masuk</h1>
                            <h1>{{ format_tanggal($record->transaction->transaction_time ?? '-') }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-filament-panels::page>
