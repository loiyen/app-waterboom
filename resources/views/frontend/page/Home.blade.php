@extends('frontend.layout.main')

@section('container')
    @include('frontend.partial.navbar')
    <div class="container mx-auto max-w-6xl mb-10 md:mb-24 lg:mt-44 mt-20">
        <div class="text-center mb-5 hidden lg:flex justify-center" data-aos="fade-up" data-aos-anchor-placement="top-center">
            <div>
                <h1 class="text-3xl text-blue-700 font-bold">
                    Hallo, Waterboomers!
                </h1>
                <span class="font-bold text-gray-700 text-sm">#PastiLebihSeru</span>
            </div>
        </div>
        <div class="swiper default-carousel relative">
            <div class="swiper-wrapper">
                @foreach ($slider as $item)
                    <div class="swiper-slide w-full h-full">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="Slide {{ $item->title }}"
                            class="w-full h-96 md:h-96  object-cover md:rounded-lg" />
                    </div>
                @endforeach
            </div>
            <button id="slider-button-left"
                class="custom-prev absolute top-1/2 -translate-y-1/2 left-3 z-20 bg-transparent w-10 h-10 rounded-full flex items-center justify-center shadow hover:bg-indigo-600 transition">
                <svg class="h-10 w-5 hover:text-white text-white" xmlns="http://www.w3.org/2000/svg" width="16"
                    height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M10.0002 11.9999L6 7.99971L10.0025 3.99719" stroke="currentColor" stroke-width="1.6"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <button id="slider-button-right"
                class="custom-next absolute top-1/2 -translate-y-1/2 right-3 z-20 bg-transparent w-10 h-10 rounded-full flex items-center justify-center shadow hover:bg-indigo-600 transition">
                <svg class="h-5 w-5 hover:text-white text-white" xmlns="http://www.w3.org/2000/svg" width="16"
                    height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M5.99984 4.00012L10 8.00029L5.99748 12.0028" stroke="currentColor" stroke-width="1.6"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <div class="swiper-pagination !bottom-3"></div>
        </div>
    </div>

    <div class="container mx-auto max-w-6xl mb-10 md:mb-24">
        <div class="flex flex-col md:flex-row justify-center text-sm md:text-base">
            <div class="w-full">
                <h1 class="text-2xl font-poppins md:text-3xl text-center text-gray-700 font-bold py-4">
                    Beli Tiket Sekarang!
                </h1>
                <div class="rounded-md shadow-lg py-3 mr-2 ml-2 bg-gradient-to-r from-blue-700 to-blue-400 ">
                    <h1 class="text-lg font-poppins font-bold text-white text-center py-3 px-2">
                        Tiket Regular
                    </h1>
                    <h5 class="text-center px-2 text-white">
                        Tiket untuk pengunjung domestik dan internasional
                    </h5>
                    <div class="flex flex-col md:flex-row justify-center gap-2 py-4 px-3 md:px-10">
                        <a href="{{ route('tiket.checkout') }}"
                            class="border text-center hover:bg-blue-700 hover:text-white bg-white outline-white rounded-full w-full md:w-full font-semibold text-gray-600 px-3 py-2">
                            Beli Tiket!
                        </a>
                        <a href="{{ route('promo.page') }}"
                            class="border text-center hover:bg-blue-700 hover:text-white bg-white outline-white rounded-full w-full md:w-full font-semibold text-gray-600 px-3 py-2">
                            Cek Promo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto max-w-6xl md:mb-24" data-aos="fade-up" data-aos-anchor-placement="top-center">
        <div class="py-5">
            <h1 class="text-center font-poppins text-gray-700 text-2xl md:text-3xl font-bold">
                Jelajah dan Explorasi
            </h1>
        </div>
        <div>
            <div class="swiper default-carousel relative">
                <div class="swiper-wrapper gap-2">
                    @foreach ($jelajah as $item)
                        <div class="swiper-slide px-2">
                            <a href="">
                                <div class="h-96 md:h-96 rounded-lg overflow-hidden shadow-md relative group">
                                    <img src="{{ $item->getFirstMediaUrl('places-images') }}" alt="{{ $item->name }}"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    <div class="absolute inset-0 mt-64 bg-black/40 flex justify-center items-center">
                                        <span class="text-white transition-transform duration-500 group-hover:scale-110">
                                            <h1 class="font-bold font-poppins text-2xl md:text-3xl text-center mb-2">
                                                {{ $item->name }}
                                            </h1>
                                            <h5 class="text-xs md:text-sm text-center py-1">
                                                Jam Oprasional
                                            </h5>
                                            <h5 class="text-xs font-semibold text-center mb-2">
                                                {{ format_jam($item->open) }} - {{ format_jam($item->close) }}
                                            </h5>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <div class="container mx-auto max-w-6xl md:mb-24" data-aos="fade-up" data-aos-anchor-placement="top-center">
        <div class="py-5">
            <h1 class="text-2xl md:text-3xl font-poppins  font-bold text-gray-700 text-center">
                Promo Spesial
            </h1>
        </div>
        <div class="swiper default-carousel relative">
            <div class="swiper-wrapper gap-4">
                @foreach ($promo as $item)
                    <div class="swiper-slide px-2">
                        <a href="{{ route('detail.promo', $item->slug) }}">
                            <div class="w-full h-64 md:h-96 rounded-lg overflow-hidden shadow-md relative group">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="Slide   1"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination !bottom-3"></div>
        </div>

    </div>
    <div class="container mx-auto max-w-6xl md:mb-24" data-aos="fade-up" data-aos-anchor-placement="top-center">
        <div class="py-5">
            <h1 class="text-2xl md:text-3xl font-poppins  font-bold text-gray-700 text-center">
                Event Waterboom
            </h1>
        </div>
        <div class="swiper default-carousel relative">
            <div class="swiper-wrapper gap-2">
                @foreach ($event as $item)
                    <div class="swiper-slide px-2">
                        <div class="h-64 md:h-96 rounded-lg overflow-hidden shadow-md relative group">
                            <img src="{{ asset('storage/' . $item->thumbail) }}" alt="Slide   1"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination !bottom-3"></div>
        </div>
    </div>

    <div class="container mx-auto max-w-6xl px-2 mb-10 md:mb-24" data-aos="fade-up" data-aos-anchor-placement="top-center">
        <div class="py-5">
            <h1 class="text-center font-poppins text-2xl md:text-3xl text-gray-700 font-bold">
                Penghargaan dan Prestasi
            </h1>
            <h5 class="px-2 py-3 fonbo text-gray-700 text-center">
                Terima kasih atas kepercayaan seluruh mitra dan pelanggan kami,
                sehingga Waterboom Jogja telah mencapai prestasi ini.
            </h5>
            <hr />
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg::grid-cols-4 gap-2">
            @foreach ($penghargaan as $item)
                <div class="w-full  flex justify-center">
                    <img src="{{ asset('storage/' . $item->image) }}"
                        class="w-24 md:w-full h-auto object-contain rounded-lg" alt="{{ $item->title }}" />
                </div>
            @endforeach
        </div>
    </div>

    <div class="container mx-auto max-w-6xl mb-10 md:mb-24" data-aos="fade-up" data-aos-anchor-placement="top-center">
        <div class="py-5">
            <h1 class="text-center  px-2 text-2xl md:text-3xl text-gray-700 font-bold">
                Artikel dan Informasi Terbaru
            </h1>
            <p class="text-center text-sm  px-2 md:text-base  py-2">
                Dapatkan informasi terbaru dari artikel kami dibawah ini.
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 px-4 md:px-0">
            <!-- Kiri: Slider -->
            <div class="col-span-1 px- mb-3">
                <div class="swiper default-carousel relative">
                    <div class="swiper-wrapper gap-2">
                        @foreach ($berita as $item)
                            <div class="swiper-slide">
                                <div class="bg-white">
                                    <img class="w-full mb-3 h-44 rounded-md object-cover transition-transform duration-500 group-hover:scale-110"
                                        src="{{ $item->getFirstMediaUrl('news-images') }}" alt="{{ $item->title }}" />
                                    <div class="mb-2">
                                        <h1 class="text-sm md:text-base mb-2 hover:text-blue-700">
                                            {{ $item->title }}
                                        </h1>
                                    </div>
                                    <div class="mb-2 py-2">
                                        <h1 class="text-xs text-gray-600 hover:text-blue-700 ">Lebih lanjut <i
                                                class="fa fa-angle-right"></i></h1>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div class="col-span-2 space-y-4 px-2">
                @foreach ($berita as $item)
                    <div class="hidden md:flex flex-col md:flex-row bg-white rounded-md  overflow-hidden">
                        <div class="h-auto md:w-40 flex-none">
                            <img src="{{ $item->getFirstMediaUrl('news-images') }}" alt="{{ $item->title }}"
                                class="w-full h-full object-cover" />
                        </div>
                        <div class="p-2 mb-4 flex flex-col justify-start space-y-1">
                            <div>
                                <h2 class="py-2 px-4 text-sm hover:text-blue-700 md:text-base ">
                                    {{ $item->title }}
                                </h2>
                                <h1 class="text-xs text-gray-600 hover:text-blue-700 py-2 px-4">Lebih lanjut <i
                                        class="fa fa-angle-right"></i></h1>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="hidden lg:flex flex-col md:flex-row justify-center bg-white overflow-hidden">
                    <a href="{{ route('blog.page') }}" class="w-full text-center text-gray-700 rounded-md py-3 font-semibold hover:bg-blue-700 hover:text-white">
                        Lihat Artikel Lainya +
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto max-w-6xl mb-6 md:mb-10" data-aos="fade-up" data-aos-anchor-placement="top-center">
        <div class="w-full px-2 py-5 flex justify-center">
            <iframe class="w-full md:w-full h-auto md:h-96 rounded-lg shadow-md"
                src="https://www.youtube.com/embed/U5BJckX4ADw?si=K9XoJgNvrWdqJgCZ" title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    </div>

    <div class="container mx-auto max-w-6xl mb-10 md:mb-10">
        <div class="py-5">
            <h1 class="text-center  px-2 text-2xl md:text-3xl text-gray-700 font-bold">
                Waterboom Partner
            </h1>
            <h5 class="px-2 py-3 fonbo text-gray-700 text-center">
                Waterboom jogja berkerja sama dengan beberapa layanan dalam pembelian tiket.
            </h5>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg::grid-cols-2 justify-center gap-2">
            @forelse ($partner as $item)
                <div class="w-full flex justify-center">
                    <img src="{{ asset('storage/' . $item->image) }}" class="w-24 md:w-32 h-auto object-contain "
                        alt="" />
                </div>
            @empty
                <div class="col-span-4 text-center text-gray-500  p-20 rounded-md">
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

    @include('frontend.partial.service')
    @include('frontend.partial.footer')
@endsection
