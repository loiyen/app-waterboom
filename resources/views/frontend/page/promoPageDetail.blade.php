@extends('frontend.layout.main')

@section('container')
    @include('frontend.partial.navbar')

    <div class="container mx-auto max-w-6xl lg:mt-32 sm:mt-16 mb-10">
        <div class="mb-5">
            <img src="{{ asset('storage/' . $promo->image) }}" class="w-full md:h-80 object-cover" alt="" />
        </div>
        <div class="text-start px-4 flex justify-center md:justify-start text-gray-700">
            <h1 class="hover:text-blue-700 text-xs cursor-pointer">Beranda</h1>
            <a href="{{ route('promo.page') }}">
                <h1 class="text-xs font-semibold">
                    <i class="fa fa-angle-right text-gray-400 px-2"></i> Promo
                </h1>
            </a>
            <h1 class="text-xs font-semibold">
                <i class="fa fa-angle-right text-gray-400 px-2"></i>
            </h1>
        </div>
    </div>

    <div class="container mx-auto max-w-6xl mb-10 px-4">
        <div class="mb-5">
            <h1 class="text-2xl md:text-3xl py-3 text-start font-bold text-gray-700">
                {{ $promo->title }}
            </h1>
        </div>
        <div class="flex flex-col md:flex-row gap-5">
            <div class="w-full mb-5 md:mb-0">
                <div class="mb-5">
                    <h1 class="font-semibold text-lg text-gray-700">
                        Hallo, Waterboomers!!
                    </h1>
                    <h1 class="leading-normal text-sm md:text-base text-justify text-gray-700">
                        {!! $promo->description !!}
                    </h1>
                </div>
                <div class="border px-5 py-3 md:text-base text-gray-700 shadow-md rounded-md text-sm mb-5">
                    <h1 class="font-bold text-lg mb-5">Priode & Ketentuan Promo</h1>
                    <div class="flex justify-start gap-1 mb-2 text-gray-700">
                        <h1 class="font-semibold">
                            <i class="fa fa-calendar"></i> Periode Pembelian :
                        </h1>
                        <h1>{{ format_tanggal($promo->start_date) }} - {{ format_tanggal($promo->end_date) }}</h1>
                    </div>
                    <div class="flex justify-start gap-1 mb-2 text-gray-700">
                        <h1 class="font-semibold">
                            <i class="fa fa-calendar"></i> Periode Kunjungan :
                        </h1>
                        <h1>{{ format_tanggal($promo->start_date) }} - {{ format_tanggal($promo->end_date) }}</h1>
                    </div>
                    <div class="flex justify-start gap-5 mb-2 text-gray-700">
                        <h1 class="font-semibold">
                            <i class="fa fa-percent"></i> Diskon :
                        </h1>
                        <h1>{{ $promo->discount_percent }} Persen</h1>
                    </div>
                </div>
                <div class="flex justify-center">
                    <a href="{{ route('tiket.checkout') }}"
                        class="w-full text-center py-4 text-sm md:text-base text-white font-semibold hover:bg-blue-800 rounded-md border bg-blue-700">
                        Beli Tiket
                    </a>
                </div>
            </div>
            <div class="w-full md:w-1/2">
                <h1 class="font-semibold text-lg mb-3 text-gray-700">Promo Lainya</h1>
                <div class="flex flex-col gap-2">
                    @foreach ($promo_lain as $item)
                        <div class="w-full rounded-md shadow-md mb-5">
                            <div>
                                <img src="{{ asset('storage/' . $item->image) }}" class="object-cover rounded-t-md"
                                    alt="" />
                            </div>
                            <div class="px-4 py-3">
                                <h1 class="text-lg font-semibold mb-3 text-gray-700">
                                    {{ $item->title }}
                                </h1>
                                <h1 class="text-sm text-start mb-3  font-semibold text-blue-700">
                                    <i class="fa fa-calendar"></i> Berlaku Sampai {{ format_tanggal($item->end_date) }}
                                </h1>
                            </div>
                            <div class="px-4 flex justify-center mb-3">
                                <a href="{{ route('detail.promo', $item->slug) }}"
                                    class="w-full text-center font-semibold text-gray-700 rounded-md border hover:bg-blue-700 hover:text-white py-3 px-3">
                                    Cek Sekarang
                                </a>
                            </div>
                        </div>
                    @endforeach



                </div>
            </div>
        </div>
    </div>
@endsection
