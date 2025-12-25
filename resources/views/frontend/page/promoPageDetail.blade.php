@extends('frontend.layout.main')

@section('container')
    @include('frontend.partial.navbar')

    <div class="container mx-auto max-w-6xl lg:mt-32 mt-24 mb-10">

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
                    <div class="mb-10">
                        <div class="flex flex-col md:flex-row items-center justify-between gap-2">
                            <span class="text-gray-500 text-sm">Bagikan Postingan :</span>
                            @php
                                $url = urlencode(request()->fullUrl());
                                $title = urlencode($promo->title);
                            @endphp

                            <div class="flex flex-wrap items-center gap-2 text-xs">
                                @php
                                    $url = urlencode(request()->fullUrl());
                                    $title = urlencode($promo->title);
                                @endphp

                                <a href="https://api.whatsapp.com/send?text={{ $title }}%20{{ $url }}"
                                    target="_blank" class="bg-green-500 text-white px-3 py-2 rounded hover:bg-green-600">
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
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-200 shadow-lg rounded-xl p-6 bg-gradient-to-br from-white to-gray-50 mb-10">
                   
                    <h1 class="font-bold text-sm md:text-xl mb-6 text-center">
                        Periode Promo
                    </h1>

                    <div
                        class="flex justify-between items-center mb-4 p-4 ">
                        <div class="flex items-center gap-2 ">
                            <i class="fa fa-calendar text-xl"></i>
                            <span class="font-medium text-xs md:text-sm">Periode Pembelian</span>
                        </div>
                        <div class="font-semibold text-xs md:text-sm text-purple-900">
                            {{ format_tanggal($promo->start_date) }} - {{ format_tanggal($promo->end_date) }}
                        </div>
                    </div>

                    <!-- Periode Kunjungan -->
                    <div
                        class="flex justify-between items-center mb-4 p-4 ">
                        <div class="flex items-center gap-2 text-blue-700">
                            <i class="fa fa-calendar text-xl"></i>
                            <span class="font-medium text-xs md:text-sm">Periode Kunjungan</span>
                        </div>
                        <div class="font-semibold text-blue-900 text-xs md:text-sm">
                            {{ format_tanggal($promo->start_date) }} - {{ format_tanggal($promo->end_date) }}
                        </div>
                    </div>

                    <div class="flex justify-between items-center p-4">
                        <div class="flex items-center gap-2 text-pink-600">
                            <i class="fa fa-percent text-xl"></i>
                            <span class="font-medium text-xs md:text-sm">Diskon</span>
                        </div>
                        <div class="font-extrabold text-xs md:text-sm  text-pink-800">
                            {{ $promo->discount_percent }}%
                        </div>
                    </div>
                </div>

                <div class=" md:text-base text-gray-700 text-sm mb-10">
                    <h1 class="font-bold text-gray-700 text-lg mb-5">Syarat & Ketentuan</h1>
                    <div class="text-justify leading-normal">
                        <p>{!! Purifier::clean($promo->description) !!}</p>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row pb-2 text-gray-700 items-center gap-5">
                    <h1 class="text-sm text-gray-500">Kunjungi media sosial kami : </h1>
                    <div class="flex flex-wrap items-center gap-2 text-xs">
                        @php
                            $url = urlencode(request()->fullUrl());
                            $title = urlencode($promo->title);
                        @endphp

                        <a href="https://www.instagram.com/username_ig" target="_blank"
                            class="font-semibold text-gray-500 border px-3 py-2 rounded hover:opacity-90 ">
                            <i class="fab fa-instagram"></i> WaterboomJogja
                        </a>
                        <a href="https://www.tiktok.com/@username_tiktok" target="_blank"
                            class=" text-gray-500 px-3 py-2 rounded flex items-center border font-semibold justify-center ">
                            <i class="fab fa-tiktok text-white-700 mr-2"></i> TikTok
                        </a>
                    </div>
                </div>
                <div>
                    <h1 class="border"></h1>
                </div>
                <div class="">
                    <h1 class=" text-sm md:text-base py-2 font-semibold text-gray-700">Galeri</h1>
                    <div class="mb-2 py-2" onclick="showImageModal('{{ asset('storage/' . $promo->image) }}')">
                        <img src="{{ asset('storage/' . $promo->image) }}"
                            class="w-full h-[500px] md:w-48 md:h-auto cursor-pointer rounded-md object-cover"
                            alt="" />
                    </div>
                </div>

            </div>
            <div class="w-full md:w-1/2">
                <h1 class="font-semibold text-lg mb-3 text-gray-700">Promo Lainya</h1>
                <div class="flex flex-col gap-2">
                    @foreach ($promo_lain as $item)
                        <div class="w-full rounded-md shadow-md mb-5">
                            <div class="overflow-hidden shadow-md relative group">
                                <img src="{{ asset('storage/' . $item->image) }}"
                                    class="w-full h-80 rounded-t-md object-cover transition-transform duration-500 group-hover:scale-110"
                                    alt="" />
                            </div>
                            <div class="px-5 py-3">
                                <h1 class="text-lg font-semibold mb-3 text-gray-700">
                                    {{ $item->title }}
                                </h1>
                                <h1 class="text-sm text-start mb-3  font-semibold text-blue-700">
                                    <i class="fa fa-calendar"></i> Berlaku Sampai {{ format_tanggal($item->end_date) }}
                                </h1>
                            </div>
                            <div class="px-5 flex justify-center mb-3">
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

    @include('frontend.partial.service')
@endsection
