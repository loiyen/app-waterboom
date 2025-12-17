@extends('frontend.layout.main')

@section('container')
    @include('frontend.partial.navbar')

    <div class="container mx-auto max-w-6xl md:mt-32 mt-24 mb-10 px-4">
        <div class="flex items-center gap-1 text-xs text-gray-700">
            <a href="/" class="hover:text-blue-700">Beranda</a>
            <i class="fa fa-angle-right text-gray-400 px-1"></i>
            <a href="{{ route('blog.page') }}" class="hover:text-blue-700">
                Artikel & Berita
            </a>
            <i class="fa fa-angle-right text-gray-400 px-1"></i>
            <span class="font-semibold">Detail Berita</span>
        </div>
    </div>

    <div class="container mx-auto max-w-6xl mb-16 px-4">
        <h1 class="text-2xl md:text-3xl font-semibold text-gray-700 mb-6">
            {{ $berita->title }}
        </h1>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i class="fa fa-user-circle text-xl"></i>
                <span>{{ $berita->user->name }}</span>
                <span>•</span>
                <span>{{ format_tanggal_jam($berita->created_at) }}</span>
            </div>

            <div class="flex flex-wrap items-center gap-2 text-xs">
                <span class="text-gray-500">Bagikan:</span>

                @php
                    $url = urlencode(request()->fullUrl());
                    $title = urlencode($berita->title);
                @endphp

                <a href="https://api.whatsapp.com/send?text={{ $title }}%20{{ $url }}"
                   target="_blank"
                   class="bg-green-500 text-white px-3 py-2 rounded hover:bg-green-600">
                    <i class="fab fa-whatsapp"></i>
                </a>

                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}"
                   target="_blank"
                   class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700">
                    <i class="fab fa-facebook-f"></i>
                </a>

                <a href="https://twitter.com/intent/tweet?url={{ $url }}&text={{ $title }}"
                   target="_blank"
                   class="bg-sky-500 text-white px-3 py-2 rounded hover:bg-sky-600">
                    <i class="fab fa-twitter"></i>
                </a>

                <button onclick="copyLink()"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-3 py-2 rounded">
                    <i class="fa fa-link"></i>
                </button>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-8">
          
            <div class="w-full">
                <div class="mb-6 w-full aspect-[16/9] overflow-hidden rounded-lg">
                    <img src="{{ $berita->getLastMediaUrl('news-images') }}"
                         class="w-full h-full object-cover"
                         alt="">
                </div>
                <div class="prose max-w-none text-gray-700 text-justify mb-6">
                    {!! Purifier::clean($berita->content) !!}
                </div>

                <p class="text-xs text-gray-500 mb-8">
                    Created by : WaterboomJogja
                </p>
                @if ($berita->getMedia('news-images')->count() > 1)
                    <div class="swiper default-carousel relative mb-10">
                        <div class="swiper-wrapper w-full">
                            @foreach ($berita->getMedia('news-images') as $item)
                                <div class="swiper-slide">
                                    <div class="aspect-[16/9] overflow-hidden rounded-lg shadow">
                                        <img src="{{ $item->getUrl() }}"
                                             class="w-full h-full object-cover"
                                             alt="{{ $item->title }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button
                            class="custom-prev absolute top-1/2 -translate-y-1/2 left-3 z-20
                                   bg-black/40 w-10 h-10 rounded-full flex items-center justify-center
                                   text-white hover:bg-indigo-600 transition">
                            ‹
                        </button>
                        <button
                            class="custom-next absolute top-1/2 -translate-y-1/2 right-3 z-20
                                   bg-black/40 w-10 h-10 rounded-full flex items-center justify-center
                                   text-white hover:bg-indigo-600 transition">
                            ›
                        </button>
                    </div>
                @endif

                <h2 class="text-lg font-bold text-blue-800 mb-4">
                    Berita Terkait
                </h2>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm text-gray-700">
                    @forelse ($related_news as $item)
                        <a href="{{ route('detail.blog', $item['news']->slug) }}"
                           class="block p-3 border rounded hover:shadow">
                            <h3 class="font-semibold hover:text-blue-600">
                                {{ $item['news']->title }}
                            </h3>
                        </a>
                    @empty
                        <div class="col-span-3 text-center text-gray-400 border p-5 rounded">
                            Belum ada
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="w-full md:w-1/3">
                <h2 class="font-semibold text-lg mb-5 text-gray-700">
                    Berita Lainnya
                </h2>

                <div class="flex flex-col gap-5">
                    @foreach ($berita_lain as $item)
                        <div class="border rounded-lg hover:shadow">
                            <div class="aspect-[16/9] overflow-hidden rounded-t-lg">
                                <img src="{{ $item->getFirstMediaUrl('news-images') }}"
                                     class="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                                     alt="">
                            </div>

                            <div class="p-4">
                                <a href="{{ route('detail.blog', $item->slug) }}">
                                    <h3 class="font-semibold text-gray-700 hover:text-blue-700">
                                        {{ $item->title }}
                                    </h3>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @include('frontend.partial.footer')

    <script>
        function copyLink() {
            navigator.clipboard.writeText('{{ request()->fullUrl() }}')
                .then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Link berhasil disalin',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
        }
    </script>
@endsection
