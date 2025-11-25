@extends('frontend.layout.main')

@section('container')
    @include('frontend.partial.navbar')

    <div class="container mx-auto max-w-6xl mt-28 md:mt-36 mb-10 px-4">
        <div class="10">
            <div class="text-start mb-4 flex justify-start text-gray-700">
                <a href="/">
                    <h1 class="hover:text-blue-700 hover:underline text-xs cursor-pointer">
                        Beranda
                    </h1>
                </a>
                <a href="{{ route('tiket.checkout') }}">
                    <h1 class="text-xs font-semibold hover:text-blue-700 hover:underline">
                        <i class="fa fa-angle-right text-gray-400 px-2"></i> Tiket
                    </h1>
                </a>
                <a href="{{ route('checkout.ticket') }}">
                    <h1 class="text-xs font-semibold hover:text-blue-700 hover:underline">
                        <i class="fa fa-angle-right text-gray-400 px-2"></i> Checkout
                    </h1>
                </a>
                <a href="#">
                    <h1 class="text-xs font-semibold hover:text-blue-700 hover:underline">
                        <i class="fa fa-angle-right text-gray-400 px-2"></i> Pembayaran
                    </h1>
                </a>
                <h1 class="text-xs font-semibold">
                    <i class="fa fa-angle-right text-gray-400 px-2"></i>
                </h1>
            </div>
        </div>

        <div class="mb-5">
            <h1 class="text-2xl md:text-3xl py-3 md:px-1 text-start font-bold text-gray-700">
                <b class="text-blue-700">Pembayaran</b> Tiket
            </h1>
        </div>

        <div class="">
            <div class="py-2">
                <h1 class="text-sm md:text-base font-semibold text-gray-700">
                    Informasi Konsumen
                </h1>
            </div>
            <form action="{{ route('create.order') }}" method="POST">
                @csrf
                <div class="pb-20 flex flex-col md:flex-row text-sm md:text-base gap-2">
                    <div class="w-full md:w-2/3 mb-5 md:mb-0 text-xs md:text-sm border rounded-md px-4 py-3">
                        <div class="flex flex-col md:flex-row gap-2 mb-2">
                            <div class="w-full">
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2" for="username1">
                                        Nama Lengkap
                                    </label>
                                    <input
                                        class="shadow appearance-none border rounded w-full py-3 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        type="text" name="name" id="name" value="{{ old('name') }}"
                                        placeholder="Nama" required />
                                    <div class="py-1 text-xs text-gray-500">
                                        <h1>* Sesuaikan dengan kartu identitas anda</h1>
                                        @error('name')
                                            <small class="text-red-700 block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row gap-2">
                            <div class="w-full">
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2" for="username1">
                                        Nomor Hanphone
                                    </label>
                                    <input
                                        class="shadow appearance-none border rounded w-full py-3 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        type="text" name="phone" id="noHp" placeholder="No handphone" />
                                    <div class="py-1 text-xs text-gray-500">
                                        <h1>* Gunakan kode negara anda, contoh : +628123456789</h1>
                                        @error('phone')
                                            <small class="text-red-700 block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2" for="username1">
                                        Email Aktif
                                    </label>
                                    <input
                                        class="shadow appearance-none border rounded w-full py-3 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        type="email" name="email" id="email" placeholder="email@example.com"
                                        required />
                                    <div class="py-1 text-xs text-gray-500">
                                        <h1>contoh : email@example.com</h1>
                                        <p>
                                            E-Tiket akan otomatis terkirim ke email setelah pembayaran
                                        </p>
                                        @error('email')
                                            <small class="text-red-700 block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row gap-2">
                            <div class="w-full">
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2" for="username1">
                                        Alamat
                                    </label>
                                    <textarea rows="2" name="address" id="alamat"
                                        class="shadow appearance-none border rounded w-full py-3 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        placeholder="Alamat " required></textarea>
                                    @error('address')
                                        <small class="text-red-700 block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row gap-2 mb-2">
                            <div class="w-full">
                                <div>
                                    <h1 class="text-sm md:text-base font-semibold text-gray-700">
                                        Syarat dan Ketentuan
                                    </h1>
                                </div>
                                <div class="border py-3 rounded-md">
                                    <h1 class="text-xs px-4 text-gray-700">
                                        Pesanan ini tidak dapat dibatalkan.
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-96 flex flex-col px-2 border shadow-md rounded-md">
                        <h1 class="py-3 px-2 font-semibold text-gray-700 mb-5">
                            Pembayaran
                        </h1>
                        <div class="flex flex-col justify-between px-2">
                            <div class="py-2 border rounded-md bg-slate-50">
                                <h1 class="py-2 px-3 text-sm text-gray-700">
                                    <b>Perhatian!</b> Selesaikan pembayaran sebelum keluar.
                                </h1>
                            </div>

                            <div class="py-3 mb-2">
                                <h1 class="font-semibold text-gray-700 mb-5">
                                    Metode Pembayaran
                                </h1>
                                <div class="w-full border py-4 px-3 rounded-md  flex items-center justify-between">
                                    <label for="metode-qris" class="flex items-center gap-2 cursor-pointer">
                                        <span><i class="fa fa-qrcode text-gray-700"></i></span>
                                        <span class="font-semibold">QRIS</span>
                                    </label>
                                    <input type="radio" name="metode" id="metode-qris" value="qris"
                                        class="w-4 h-4 text-blue-600 border rounded-full" />
                                </div>
                                @error('metode')
                                    <small class="text-red-700 block mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="w-full py-3 text-xs md:text-sm text-gray-700 mb-3">
                                <div class="flex items-center">
                                    <input type="checkbox" name="approv" id="approv"
                                        class="w-4 h-4 md:w-6 md:h-6  text-blue-600 focus:ring-blue-500 border-gray-300" />
                                    <label for="approv" class="ml-2">
                                        Saya menyetujui syarat dan ketentuan yang berlaku.
                                    </label>
                                </div>
                                @error('approv')
                                    <small class="text-red-700 block mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                            <div
                                class="fixed md:static bottom-0 left-0 right-0 items-center bg-white shadow-[0_-2px_10px_rgba(0,0,0,0.1)] md:shadow-none border-t z-50 py-3 md:border-0">
                                <hr class="hidden lg:block">
                                <div
                                    class="w-full text-sm md:flex-row items-center flex justify-between text-gray-700 px-4">
                                    <div>
                                        @php
                                            $total_price = $total_price ?? 0;
                                            $total_priceService = $total_priceService ?? 0;
                                            $biaya_transaksi = 500;
                                            $grand_total = $total_price + $total_priceService + $biaya_transaksi;
                                        @endphp
                                        <h1 class="mt-2 mb-0">Total Pembayaran</h1>
                                        <span class="font-bold text-base total-harga">
                                            {{ number_format($grand_total, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div>
                                        <button type="submit"
                                            class="w-full text-xs md:text-sm px-12 py-3 font-semibold text-center bg-blue-700 text-white hover:bg-blue-800 rounded-lg">
                                            Bayar
                                        </button>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
