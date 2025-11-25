@extends('frontend.layout.main')

@section('container')
    @include('frontend.partial.navbar')

    <div class="container mx-auto max-w-6xl mt-28 md:mt-36 mb-10 px-4">
        <div class="mb-5">
            <div class="text-start mb-4 flex justify-start text-gray-700">
                <a href="/">
                    <h1 class="hover:text-blue-700 hover:underline text-xs cursor-pointer">
                        Beranda
                    </h1>
                </a>
                <a href="{{ route('history.buy') }}">
                    <h1 class="text-xs font-semibold hover:text-blue-700 hover:underline">
                        <i class="fa fa-angle-right text-gray-400 px-2"></i> Riwayat
                    </h1>
                </a>
                <h1 class="text-xs font-semibold hover:text-blue-700 hover:underline">
                    <i class="fa fa-angle-right text-gray-400 px-2"></i> Detail
                </h1>
            </div>
        </div>
        <div class="text-xs md:text-sm flex justify-center py-1 mb-5">
            <div class="justify-center text-center">
                <img src="{{ asset('img/suc.png') }}" class="w-16 h-16 mb-3 mx-auto " alt="">
                <h1 class=" text-gray-700 font-semibold">Sukses!</h1>
                <h1 class=" text-gray-500 text-xs">{{ format_tanggal_jam($order->created_at) }}</h1>
            </div>
        </div>
        <div class="mb-5 border  text-xs md:text-sm rounded-md shadow-sm">
            <div class="text-gray-700 flex mt-3 mb-3 px-3 justify-between ">
                <div>
                    <h1 class="text-gray-600 mb-1">Kode Pemesanan</h1>
                    <h1 class="text-gray-700 font-semibold">{{ $order->order_code }}</h1>
                </div>
                <div>
                    <h1 class="text-gray-600 mb-1">Tanggal Pemesanan</h1>
                    <h1 class="text-gray-700 font-semibold">{{ format_tanggal($order->order_date) }}</h1>
                </div>
            </div>
        </div>
        <div class="mb-5">
            <div class="text-xs md:text-sm border rounded-md">
                <h1 class="text-xs md:text-sm px-3 mt-3 mb-2 font-semibold text-gray-700">Item Tiket ({{ $total_tiket }})
                </h1>
                @foreach ($order->items as $item)
                    <div class="py-3 px-3 flex justify-between">
                        <div>
                            <h1 class="mb-2">{{ $item->tiket->ticket_name }} - <span
                                    class="text-gray-500">{{ $item->category_ticket->name }}</span></h1>
                            <h1 class="text-gray-500">( {{ $item->qty }} x {{ 'Rp' . number_format($item->price) }})</h1>
                        </div>
                        <h1>{{ 'Rp' . number_format($item->qty * $item->price) }}</h1>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mb-10">
            <div class="text-xs md:text-sm border rounded-md">
                <h1 class="text-xs md:text-sm px-3 mt-3 mb-2 font-semibold text-gray-700">Layanan Tambahan (10)</h1>
                @forelse ($order->serviceItem as $item)
                    <div class="py-3 px-3 flex justify-between">
                        <div>
                            <h1 class="mb-2">{{ $item->tiket->ticket_name }} - <span
                                    class="text-gray-500">{{ $item->category_ticket->name }}</span></h1>
                            <h1 class="text-gray-500">( {{ $item->qty }} x {{ 'Rp' . number_format($item->price) }})
                            </h1>
                        </div>
                        <h1>{{ 'Rp' . number_format($item->qty * $item->price) }}</h1>
                    </div>
                @empty
                    <div>
                        <h1 class="text-xs md:text-sm px-3 p-10 text-center text-gray-500">Tidak ada layanan</h1>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="mb-5 text-xs md:text-sm">
            <h1 class="text-xs md:text-sm text-center font-semibold text-gray-700 mb-3">Pembayaran</h1>
            <div class="border rounded-md shadow-md">
                <div class="flex justify-between text-gray-700 py-1 mt-2 px-3">
                    <h1 class="text-gray-600">Tanggal Transaksi</h1>
                    <h1 class="text-gray-700">{{ format_tanggal_jam($order->transaction->transaction_time) }}</h1>
                </div>
                <div class="flex justify-between text-gray-700 py-1 px-3">
                    <h1 class="text-gray-600">Metode Pembayaran</h1>
                    <h1 class="text-gray-700">{{ $order->transaction->payment_type }}</h1>
                </div>
                <div class="flex justify-between  py-1 px-3">
                    <h1 class="text-gray-600">Status Transaksi</h1>
                    @if ($order->transaction->transaction_status == 'PENDING')
                        <h1 class="text-gray-700">Menunggu!</h1>
                    @elseif($order->transaction->transaction_status == 'EXPIRED')
                        <h1 class="text-gray-700">Gagal!</h1>
                    @elseif($order->transaction->transaction_status == 'PAID')
                        <h1 class="text-gray-700">Berhasil!</h1>
                    @elseif($order->transaction->transaction_status == 'UNPAID')
                        <h1 class="text-gray-700">Belum bayar!</h1>
                    @endif

                </div>
                <div class="flex justify-between text-gray-700 py-1 px-3 mb-2">
                    <h1 class="text-blue-700 font-semibold">Total</h1>
                    <h1 class="text-blue-700 font-semibold">{{ 'Rp' . number_format($order->transaction->gross_amount) }}
                    </h1>
                </div>

            </div>
        </div>
        <div class="mb-5 text-xs md:text-sm">
            <div class="flex justify-between gap-3">
                <a href="{{ route('history.buy') }}"
                    class="border text-center font-semibold  rounded-md bg-blue-700 text-white hover:bg-blue-800 py-3 px-3 w-full">Riwayat</a>
                <a href="{{ route('payment.tiket') }}"
                    class="border border-blue-700 text-gray-700 font-semibold hover:bg-blue-700 hover:text-white py-3 px-3 w-full text-center rounded-md ">Beli
                    lagi</a>
            </div>
        </div>
    </div>
@endsection
