@extends('frontend.layout.main')

@section('container')
    @include('frontend.partial.navbar')

    <div class="container mx-auto max-w-6xl lg:mt-32 mt-20 mb-10">
        <div class="mb-5">
            @if (!empty($banner) && $banner->count())
                <img src="{{ asset('storage/' . $banner->first()->image) }}" class="w-full md:h-80 object-cover"
                    alt="" />
            @else
                <img src="{{ asset('notfon.png') }}" class="w-full md:h-80 object-cover" alt="" />
            @endif
        </div>

        <div class="text-start px-4 flex justify-center md:justify-start text-gray-700">
            <a href="/">
                <h1 class="hover:text-blue-700 text-xs cursor-pointer">Beranda</h1>
            </a>
            <a href="{{ route('about.careers') }}">
                <h1 class="text-xs font-semibold">
                    <i class="fa fa-angle-right text-gray-400 px-2"></i> Careers
                </h1>
            </a>

        </div>
    </div>

    <div class="container mx-auto max-w-6xl mb-10 px-4">
        <div class="mb-10">
            <h1 class="text-2xl md:text-3xl text-start font-bold text-gray-700">
                <span class="text-blue-700">Pengumuman</span> Lowongan Kerja Waterboom
            </h1>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-10">
            @forelse ($data_loker as $item)
                <div
                    class="mb-5 rounded-md shadow-lg hover:shadow-sm transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 flex flex-col justify-between">
                    <div>
                        <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-52 rounded-t-lg" alt="" />
                        <div class="px-3 pt-3 mb-1">
                            <h1 class="text-lg text-center text-gray-700 font-semibold ">{{ $item->position }}</h1>
                        </div>
                    </div>
                    <div class="px-3 mb-3 mt-auto">
                        <div class="mb-3 ">
                            <h1 class="text-sm py-4 mb-2 text-center font-semibold text-blue-700">
                                <i class="fa fa-calendar"></i> Berlaku Sampai {{ format_tanggal($item->deadline) }}
                            </h1>
                            <a href="{{ route('detail.careers', $item->slug) }}"
                                class="w-full flex justify-center text-center  text-sm md:text-base font-semibold text-gray-700 rounded-md border hover:bg-blue-700 hover:text-white py-3 px-3">
                                Cek Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center text-gray-500  p-20 rounded-md bg-slate-50">
                    <div class="flex justify-center items-center mt-10 mb-5">
                        <img src="{{ asset('img/notfon.png') }}" class="w-16" alt="">
                    </div>
                    <div class="items-center">
                        <h1 class="font-semibold">Tidak di temukan!</h1>
                    </div>
                </div>
            @endforelse


        </div>
    </div>
@endsection
