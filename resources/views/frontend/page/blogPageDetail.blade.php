@extends('frontend.layout.main')

@section('container')
    @include('frontend.partial.navbar')

    <div class="container mx-auto max-w-6xl lg:mt-32 sm:mt-16 mb-10">
        <div class="mb-5">
            <img src="{{ $berita->getFirstMediaUrl('news-images') }}" class="w-full md:h-80 object-cover"
                alt="" />
        </div>
        <div class="text-start px-4 flex justify-center md:justify-start text-gray-700">
            <a href="/">
                <h1 class="hover:text-blue-700 text-xs cursor-pointer">Beranda</h1>
            </a>

            <a href="{{ route('blog.page') }}">
                <h1 class="hover:text-blue-700 text-xs font-semibold">
                    <i class="fa fa-angle-right text-gray-400 px-2"></i> Blog
                </h1>
            </a>
            <h1 class="text-xs font-semibold">
                <i class="fa fa-angle-right text-gray-400 px-2"></i>
            </h1>
        </div>
    </div>

    <div class="container mx-auto max-w-6xl mb-10 px-4">
        <div class="mb-10 md:mb-5 md:flex-row md:items-center rounded-md py-3 justify-between">
            <div class="text-2xl md:text-3xl mb-5 w-full text-start text-gray-700">
                <h1 class="font-bold">
                    {{ $berita->title }}
                </h1>
            </div>
            <div class="flex  gap-2 text-xs text-gray-700">
                <h1><i class="fa fa-user"></i> {{ $berita->user->name }}</h1>
                <h1><i class="fa fa-calendar"></i> {{ format_tanggal($berita->created_at) }}</h1>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-5">
            <div class="w-full mb-5 md:mb-0">
                <div class="mb-4">
                    <img src="{{ $berita->getLastMediaUrl('news-images') }}"
                        class="rounded-t-lg w-full h-72" alt="" />
                </div>
                <div class="mb-4 text-sm md:text-base leading-normal text-justify">
                    <p class="text-gray-700">
                        {!! $berita->content !!}
                    </p>
                </div>
                <div class="mb-2">
                    <h1 class="text-xs text-gray-700">Created by : WaterboomJogja </h1>
                </div>
                <div>
                    <div class="swiper default-carousel relative ">
                        <div class="swiper-wrapper w-96">
                            @foreach ($berita->getMedia('news-images')  as $item)
                                <div class="swiper-slide">
                                        <div class="h-96 md:h-96 overflow-hidden shadow-md relative group">
                                            <img src="{{ $item->getUrl('') }}" alt="{{ $item->title }}"
                                                class="w-full h-full object-cover" />
                                        </div>
                                </div>
                            @endforeach
                        </div>
                        <button id="slider-button-left"
                            class="custom-prev absolute top-1/2 -translate-y-1/2 left-3 z-20 bg-transparent w-10 h-10 rounded-full flex items-center justify-center shadow hover:bg-indigo-600 transition">
                            <svg class="h-10 w-5 hover:text-white text-white" xmlns="http://www.w3.org/2000/svg"
                                width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M10.0002 11.9999L6 7.99971L10.0025 3.99719" stroke="currentColor"
                                    stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button id="slider-button-right"
                            class="custom-next absolute top-1/2 -translate-y-1/2 right-3 z-20 bg-transparent w-10 h-10 rounded-full flex items-center justify-center shadow hover:bg-indigo-600 transition">
                            <svg class="h-5 w-5 hover:text-white text-white" xmlns="http://www.w3.org/2000/svg"
                                width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M5.99984 4.00012L10 8.00029L5.99748 12.0028" stroke="currentColor"
                                    stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex justify-between items-center flex-col md:flex-row">
                    <h1 class="mb-3 font-semibold text-gray-700">Bagikan Postingan : </h1>
                    <div class="flex flex-col md:flex-row gap-3 mb-3">
                        @php
                            $url = urlencode(request()->fullUrl());
                            $title = urlencode($berita->title);
                        @endphp
                        <a href="https://api.whatsapp.com/send?text={{ $title }}%20{{ $url }}"
                            target="_blank" class="bg-green-500 text-white px-3 py-2 rounded-md hover:bg-green-600">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}" target="_blank"
                            class="bg-blue-600 text-white px-3 py-2 rounded-md hover:bg-blue-700">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ $url }}&text={{ $title }}"
                            target="_blank" class="bg-sky-500 text-white px-3 py-2 rounded-md hover:bg-sky-600">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                        <button
                            onclick="navigator.clipboard.writeText('{{ request()->fullUrl() }}'); alert('Link disalin!')"
                            class="bg-gray-300 text-gray-800 px-3 py-2 rounded-md hover:bg-gray-400">
                            <i class="fa fa-link"></i> Salin
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/2">
                <h1 class="font-semibold text-lg mb-5 text-gray-700">
                    Berita Lainya
                </h1>
                <div class="flex flex-col  gap-2">

                    @foreach ($berita_lain as $item)
                        <div class="w-full rounded-lg border hover:shadow-md mb-5">
                            <div>
                                <img src="{{ $item->getFirstMediaUrl('news-images') }}"
                                    class="object-cover rounded-t-md" alt="image" />
                            </div>
                            <div class="px-4 py-3">
                                <a href="{{ route('detail.blog', $item->slug) }}">
                                    <h1 class="text-lg hover:text-blue-700 font-semibold mb-3 text-gray-700">
                                        {{ $item->title }}
                                    </h1>
                                </a>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection
