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

            <a href="{{ route('event.page') }}">
                <h1 class="hover:text-blue-700 text-xs text-gray-700 ">
                    <i class="fa fa-angle-right  px-2"></i> Acara
                </h1>
            </a>
            <h1 class="text-xs font-semibold">
                <i class="fa fa-angle-right text-gray-400 px-2"></i> Detail Acara
            </h1>
        </div>
    </div>

    <div class="container mx-auto max-w-6xl mb-10 px-4">
        <div class="flex flex-col md:flex-row justify-between mb-5 gap-5">

            <div class="w-full">
                <div class="mb-5">
                    <h1 class="text-2xl md:text-3xl font-semibold text-gray-700">
                        {{ $data_event->title }}
                    </h1>
                </div>

                <div class="border p-5 text-sm md:text-base rounded-md shadow-sm mb-10 space-y-2">
                    <div class="flex justify-between text-gray-700 px-2">
                        <span>Masa Event</span>
                        <span class="font-semibold">
                            {{ format_tanggal($data_event->start_date) }} – {{ format_tanggal($data_event->end_date) }}
                        </span>
                    </div>
                    <div class="flex justify-between text-gray-700 px-2">
                        <span>Lokasi</span>
                        <span class="font-semibold">{{ $data_event->location }}</span>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row justify-between items-center gap-5 mb-10">
                    <a href="{{ $data_event->link }}" target="_blank" rel="noopener noreferrer" class="bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 px-5 rounded-md">
                        Daftar Sekarang!
                    </a>
                </div>
                <div class="mb-5 cursor-pointer"
                    onclick="showImageModal('{{ asset('storage/' . $data_event->thumbail) }}')">
                    <h1 class="mb-2 text-sm md:text-base font-semibold ">Galeri</h1>
                    <img src="{{ asset('storage/' . $data_event->thumbail) }}"
                        class="w-full h-full md:w-56 md:h-64 rounded-md object-cover" alt="">
                </div>
                <div class="border mb-5 mt-4">
                </div>

                <div class="text-justify text-sm md:text-base text-gray-700 mb-5">
                    <p>{!! Purifier::clean($data_event->description) !!}</p>
                </div>
                <div class="text-justify text-sm border rounded-md p-5 md:text-base text-gray-700 mb-5">
                    <p>{!! Purifier::clean($data_event->ketentuan) !!}</p>
                </div>
                <div class="flex flex-col md:flex-row justify-between items-center gap-2">
                    <span class="text-gray-500 text-sm">Bagikan Postingan :</span>

                    @php
                        $url = urlencode(request()->fullUrl());
                        $title = urlencode($data_event->title);
                    @endphp

                    <div class="flex gap-3 text-xs">
                        <a href="https://api.whatsapp.com/send?text={{ $title }}%20{{ $url }}"
                            target="_blank" class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-md">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>

                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}" target="_blank"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>

                        <a href="https://twitter.com/intent/tweet?url={{ $url }}&text={{ $title }}"
                            target="_blank" class="bg-sky-500 hover:bg-sky-600 text-white px-3 py-2 rounded-md">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                        <button onclick="copyLink()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-3 py-2 rounded-md">
                            <i class="fa fa-link"></i> Salin
                        </button>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/2">
                <h1 class="text-lg font-semibold text-gray-700 mb-5">Acara Lainnya</h1>
                <div class="flex flex-col  gap-2">
                    @foreach ($event_lain as $item)
                        <div class="w-full rounded-lg border hover:shadow-md mb-5">
                            <div class="overflow-hidden  relative group  ">
                                <img src="{{ asset('storage/' . $item->thumbail) }}"
                                    class="object-cover w-full h-80 rounded-t-md 
                                transition-transform duration-500 group-hover:scale-110"
                                    alt="image" />
                            </div>
                            <div class="">
                                <a href="{{ route('event.detail', $item->slug) }}">
                                    <h1 class="text-lg px-5 py-3 hover:text-blue-700 font-semibold  text-gray-700">
                                        {{ $item->title }}
                                    </h1>
                                </a>
                                <h1 class="text-sm px-5 py-3 text-start mb-3  font-semibold text-blue-700">
                                    <i class="fa fa-calendar"></i> Berlaku Sampai {{ format_tanggal($item->end_date) }}
                                </h1>
                                <div class="px-5 flex justify-center mb-3">
                                    <a href="{{ route('event.detail', $item->slug) }}"
                                        class="w-full text-center font-semibold text-gray-700 rounded-md border hover:bg-blue-700 hover:text-white py-3 px-3">
                                        Cek Sekarang
                                    </a>
                                </div>
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
            <img id="modalImage" src="" class="max-h-[100vh] max-w-[100vw] rounded-lg shadow-lg">
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

    @include('frontend.partial.footer')
@endsection
