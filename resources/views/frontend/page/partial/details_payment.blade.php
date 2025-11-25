@php

    $total_price = $total_price ?? 0;
    $total_priceService = $total_priceService ?? 0;

    $biaya_transaksi = 500;
    $grand_total = $total_price + $total_priceService + $biaya_transaksi;
@endphp

<div class="border shadow-md py-2 px-3 rounded-lg">
    <div class="mb-4">
        <h1 class="text-center py-2 text-sm md:text-base font-semibold text-gray-700">
            Rincian Pembayaran
        </h1>
    </div>
    <hr>
    <div class="py-3">
        <div class="py-2">
            <div class="flex justify-between items-center text-gray-700 px-2 mb-2">
                <h1 class="text-xs md:text-sm font-semibold ">Subtotal Tiket</h1>
                <h1 class="text-xs md:text-sm font-semibold">
                    Rp{{ number_format($total_price, 0, ',', '.') }}
                </h1>
            </div>
            <hr>
        </div>

        {{-- Subtotal Layanan --}}
        <div class="py-2">
            <div class="flex justify-between items-center text-gray-700 px-2 mb-2">
                <h1 class="text-xs md:text-sm font-semibold ">Subtotal Layanan</h1>
                <h1 class="text-xs md:text-sm font-semibold">
                    Rp{{ number_format($total_priceService, 0, ',', '.') }}
                </h1>
            </div>
            <hr>
        </div>

        {{-- Biaya lainnya --}}
        <div class="py-2">
            <div class="text-gray-700 px-2 mb-2">
                <h1 class="text-xs md:text-sm font-semibold mb-2">Biaya lainnya</h1>
                <div class="flex justify-between">
                    <h1 class="text-xs md:text-sm text-gray-500">- Biaya transaksi</h1>
                    <h1 class="text-xs md:text-sm text-gray-500 font-semibold">
                        Rp{{ number_format($biaya_transaksi, 0, ',', '.') }}
                    </h1>
                </div>
            </div>
            <hr>
        </div>
        <div class="py-3">
            <form action="#">
                <div class="flex px-2 gap-1">
                    <input
                        class="appearance-none text-sm border rounded w-full py-3 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="username1" type="text" placeholder="Kode promo" />
                    <button type="submit" class="border hover:text-white hover:bg-blue-700 text-blue-700 rounded py-2 px-3"><i
                            class="fa fa-paper-plane"></i></button>
                </div>
            </form>
        </div>
        <div class="py-2">
            <div class="flex justify-between items-center font-semibold px-2">
                <h1 class="text-xs md:text-sm">Total</h1>
                <h1 class="text-xs md:text-sm font-semibold text-blue-700">
                    Rp{{ number_format($grand_total, 0, ',', '.') }}
                </h1>
            </div>
        </div>
    </div>

    <div
        class="fixed md:static bottom-0 left-0 right-0 items-center bg-white shadow-[0_-2px_10px_rgba(0,0,0,0.1)] md:shadow-none border-t z-50 py-3 md:border-0">
        <hr class="hidden lg:block">
        <div class="w-full text-sm md:flex-row items-center flex justify-between text-gray-700 px-4">
            <div>
                <h1 class="mt-2 mb-0">Total Pembayaran</h1>
                <span class="font-bold text-base total-harga">
                    Rp{{ number_format($grand_total, 0, ',', '.') }}
                </span>
            </div>
            <div>
                <a href="{{ route('payment.tiket') }}"
                    class="w-full text-xs md:text-sm px-4 py-3 font-semibold text-center bg-blue-700 text-white hover:bg-blue-800 rounded-lg">
                    Lanjut Pembayaran
                </a>
            </div>
        </div>
    </div>

</div>
