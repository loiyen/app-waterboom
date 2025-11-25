@extends('frontend.layout.main')

@section('container')
    @include('frontend.partial.navbar')

    <div class="container mx-auto max-w-6xl lg:mt-32 sm:mt-16 mb-10">
        <div class="swiper default-carousel relative">
            <div class="swiper-wrapper">
                @foreach ($berita_slider as $item)
                    <div class="swiper-slide">
                        <a href="{{ route('detail.blog', $item->slug) }}">
                            <div class="h-96 md:h-96 overflow-hidden shadow-md relative group">
                                <img src="{{ $item->getFirstMediaUrl('news-images') }}" alt="Slide   1"
                                    class="w-full h-full object-cover" />
                                <div class="absolute mt-72 left-0 inset-0 bg-black/40 flex justify-center items-center">
                                    <span class="text-white text-lg md:text-2xl">
                                        <h1 class="font-bold text-center mb-2 px-3">
                                            {{ $item->title }}
                                        </h1>
                                        <div class="flex justify-center gap-2">
                                            <h5 class="text-xs text-center">
                                                <i class="fa fa-user"></i> {{ $item->user->name }}
                                            </h5>
                                            <h5 class="text-xs text-center">
                                                <i class="fa fa-calendar"></i> {{ format_tanggal($item->created_at) }}
                                            </h5>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </a>
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
            <div class="text-start px-4 mb-0 flex justify-center md:justify-start text-gray-700">
                <h1 class="hover:text-blue-700 text-xs cursor-pointer">Beranda</h1>
                <h1 class="text-xs font-semibold">
                    <i class="fa fa-angle-right text-gray-400 px-2"></i> Blog
                </h1>
            </div>
        </div>
    </div>

    <div class="container mx-auto max-w-6xl mb-10 px-4">
        <div class="flex flex-col mb-10 md:mb-5 md:flex-row md:items-center rounded-md py-3 justify-between">
            <div class="text-2xl md:text-3xl py-3 w-full text-start text-gray-700">
                <h1 class="font-bold"> <b class="text-blue-700">Berita</b> Terbaru Seputar Waterboom!</h1>
                <h1 class="text-sm md:text-base text-gray-600">
                    Temukan pengalaman tak terlupakan di taman rekreasi air terbesar
                    Yogyakarta
                </h1>
            </div>

            <div class="relative w-full md:w-2/3">
                <input
                    class="w-full pl-10 text-xs md:text-sm pr-4 py-2 rounded-md border shadow-sm text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    id="search-input" type="text" placeholder="Cari Berita..." />
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <i class="fa fa-search"></i>
                </span>
            </div>

        </div>

        <div class="flex flex-col md:flex-row gap-5">

            <div id="berita-container" class="w-full mb-5 md:mb-0">
                @include('frontend.page.partial.blog_list', ['berita' => $berita])
            </div>

            <div class="w-full md:w-1/2">
                <h1 class="font-semibold text-lg mb-5 text-gray-700">
                    Berita Lainya
                </h1>
                <div class="flex flex-col gap-2">
                    @foreach ($berita_lain as $item)
                        <div class="w-full rounded-lg border hover:shadow-md mb-5">
                            <div>
                                <img src="{{ $item->getFirstMediaUrl('news-images') }}" class="object-cover rounded-t-md"
                                    alt="" />
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

    <script>
        $(document).ready(function() {
            let typingTimer;
            let delay = 500;
            let isLoading = false;


            $('#search-input').on('keypress', function(e) {
                if (e.which === 13) e.preventDefault();
            });

            $('#search-input').on('keyup', function() {
                clearTimeout(typingTimer);
                let query = $(this).val();

                typingTimer = setTimeout(function() {
                    if (isLoading) return;
                    isLoading = true;

                    $.ajax({
                        url: "{{ route('blog.search') }}",
                        type: 'GET',
                        data: {
                            q: query
                        },
                        beforeSend: function() {
                            $('#berita-container').html(`
                        <div class="flex justify-center py-10">
                            <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500"></div>
                        </div>
                        <p class="text-center text-gray-500 mt-3">Memuat data...</p>
                    `);
                        },
                        success: function(response) {
                            $('#berita-container').html(response);
                        },
                        complete: function() {
                            isLoading = false;
                        },
                        error: function(xhr) {
                            $('#berita-container').html(
                                '<p class="text-red-500 p-4">Terjadi kesalahan.</p>'
                            );
                        }
                    });
                }, delay);
            });

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                $.get(url, function(response) {
                    let html = $(response).find('#berita-container').html();
                    $('#berita-container').html(html);
                });
            });
        });
    </script>
@endsection
