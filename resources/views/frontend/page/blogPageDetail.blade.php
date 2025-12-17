@extends('frontend.layout.main')

@section('container')
    @include('frontend.partial.navbar')

    <div class="container mx-auto max-w-6xl md:mt-32 mt-24 mb-10">
        {{-- <div class="mb-5">
            <img src="{{ $berita->getFirstMediaUrl('news-images') }}" class="w-full md:h-80 object-cover" alt="" />
        </div> --}}
        <div class="text-start px-4 flex justify-center md:justify-start text-gray-700">
            <a href="/">
                <h1 class="hover:text-blue-700 text-xs cursor-pointer">Beranda</h1>
            </a>

            <a href="{{ route('blog.page') }}">
                <h1 class="hover:text-blue-700 text-xs text-gray-700 ">
                    <i class="fa fa-angle-right  px-2"></i> Artikel & Berita
                </h1>
            </a>
            <h1 class="text-xs font-semibold">
                <i class="fa fa-angle-right text-gray-400 px-2"></i> Detail Berita
            </h1>
        </div>
    </div>

    <div class="container mx-auto max-w-6xl mb-10 px-4">
        <div class="mb-10 md:mb-5 md:flex-row md:items-center rounded-md py-3 justify-between">
            <div class="text-2xl md:text-3xl mb-10 w-full text-start text-gray-700">
                <h1 class="font-semibold">
                    {{ $berita->title }}
                </h1>
            </div>
            <div class="flex flex-col md:flex-row justify-between mb-5  items-center">
                <h1 class="text-sm mb-2 md:text-base text-gray-400">{{ format_tanggal_jam($berita->created_at) }}</h1>
                <div class="flex flex-wrap items-center gap-2 text-xs">
                    <span class="text-gray-500">Bagikan:</span>
                    @php
                        $url = urlencode(request()->fullUrl());
                        $title = urlencode($berita->title);
                    @endphp

                    <a href="https://api.whatsapp.com/send?text={{ $title }}%20{{ $url }}" target="_blank"
                        class="bg-green-500 text-white px-3 py-2 rounded hover:bg-green-600">
                        <i class="fab fa-whatsapp"></i>
                    </a>

                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}" target="_blank"
                        class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700">
                        <i class="fab fa-facebook-f"></i>
                    </a>

                    <a href="https://twitter.com/intent/tweet?url={{ $url }}&text={{ $title }}"
                        target="_blank" class="bg-sky-500 text-white px-3 py-2 rounded hover:bg-sky-600">
                        <i class="fab fa-twitter"></i>
                    </a>

                    <button onclick="copyLink()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-3 py-2 rounded">
                        <i class="fa fa-link"></i>
                    </button>
                </div>
            </div>
            <div class="flex gap-2 items-center text-xs text-gray-700">
                <i class="fa fa-user-circle text-2xl text-gray-400"></i>
                <h1 class="text-sm md:text-base text-gray-600">{{ $berita->user->name }}</h1>
            </div>
        </div>

        <div class="">
            <div class="w-full mb-5 md:mb-0">
                <div class="mb-4">
                    <img src="{{ $berita->getLastMediaUrl('news-images') }}" class="rounded-t-lg w-full h-full"
                        alt="" />
                </div>
                <div class="flex flex-col md:flex-row gap-5">
                    <div class="w-full">
                        <div class="py-5 mb-5 text-sm md:text-base leading-normal text-justify">
                            <p class="text-gray-700">
                                {!! Purifier::clean($berita->content) !!}
                            </p>
                        </div>
                        <div class="">
                            <h1 class="text-xs text-gray-700">Created by : WaterboomJogja </h1>
                            <div class="grid grid-cols-2 md:grid-cols-3">
                                @foreach ($berita->getMedia('news-images') as $item)
                                    <div class="mb-2 py-2 cursor-pointer"
                                        onclick="showImageModal('{{ $item->getUrl() }}')">
                                        <div class="overflow-hidden rounded-md">
                                            <img src="{{ $item->getUrl() }}" class="w-full h-full object-cover"
                                                alt="{{ $item->name }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                    <div class="w-full md:w-1/2">
                        <div class="py-5">
                            <h1 class="font-semibold text-lg mb-5 text-gray-700">
                                Berita Lainya
                            </h1>
                            <div class="flex flex-col  gap-2">
                                @foreach ($berita_lain as $item)
                                    <div class="w-full rounded-lg border hover:shadow-md mb-5">
                                        <div class="overflow-hidden shadow-md relative group">
                                            <img src="{{ $item->getFirstMediaUrl('news-images') }}"
                                                class="object-cover rounded-t-md transition-transform duration-500 group-hover:scale-110"
                                                alt="image" />
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



                <div class="md:flex-row">
                    <h1 class="text-lg font-bold text-blue-800">Berita Terkait</h1>
                    <div class="grid grid-cols-2 md:grid-cols-3 text-sm py-3 gap-4 text-gray-700 ">
                        @forelse ($related_news as $item)
                            @php
                                $news = $item['news'];
                                $score = $item['score'];
                            @endphp
                            <a href="{{ route('detail.blog', $news->slug) }}" class="block group">
                                <div class="p-2">
                                    <h3 class="font-semibold text-sm mb-1 group-hover:text-blue-600">
                                        {{ $news->title }}
                                    </h3>

                                    {{-- Score opsional (debug) --}}
                                    {{-- <p class="text-xs text-gray-500">Skor: {{ number_format($score, 4) }}</p> --}}
                                </div>
                            </a>
                        @empty
                            <div class="border rounded-md col-span-4 p-5 w-full">
                                <h1 class="text-center text-gray-400">belum ada</h1>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>

        </div>
    </div>
    @include('frontend.partial.footer')

    <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50">
        <div class="relative">
            <button onclick="closeImageModal()"
                class="absolute -top-4 -right-4 bg-white text-black rounded-full px-2 py-1 shadow hover:bg-gray-200">✕</button>
            <img id="modalImage" src="" class="max-h-[90vh] max-w-[90vw] rounded-lg shadow-lg">
        </div>
    </div>

    <script>
        function showImageModal(url) {
            document.getElementById('modalImage').src = url;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }
    </script>

    <script>
        function copyLink() {
            navigator.clipboard.writeText('{{ request()->fullUrl() }}')
                .then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Link berhasil disalin.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Tidak dapat menyalin link.',
                    });
                });
        }
    </script>
@endsection
