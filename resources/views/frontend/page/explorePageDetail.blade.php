@extends('frontend.layout.main')
@section('container')
    @include('frontend.partial.navbar')

    <div class="container mx-auto max-w-6xl md:mt-32 mt-24 mb-10">

        <div class="mb-5">
            <div class="text-start mb-5 flex md:justify-start justify-center text-gray-700">
                <h1 class="hover:text-blue-700 text-xs cursor-pointer">Beranda</h1>
                <a href="{{ route('jelajah.category', $detail_data->categoryplace->slug) }}">
                    <h1 class="text-xs font-semibold">
                        <i class="fa fa-angle-right text-gray-400 px-2"></i> {{ $detail_data->categoryplace->name }}
                    </h1>
                </a>
                <h1 class="text-xs font-semibold">
                    <i class="fa fa-angle-right text-gray-400 px-2"></i> {{ $detail_data->name }}
                </h1>
            </div>
        </div>
    </div>

    <div class="container mx-auto max-w-6xl px-4 md:px-1 mb-10">
        <div class="">
            <h1 class="text-2xl text-gray-700 font-bold mb-2 md:mb-0">
                <b class="text-blue-700">{{ $detail_data->name }}</b>
            </h1>
        </div>
        <div>
            <div class="flex flex-col md:flex-row gap-5">
                <div class="w-full md:w-full mb-3">
                    <div class="mb-5 mt-3 text-xs md:text-sm">
                        <div class="flex justify-between border rounded-md shadow-sm py-4 px-6">
                            <div>
                                <h1 class="text-gray-500 text-xs mb-1 font-semibold">
                                    Jam Oprasional
                                </h1>
                                <h1 class="text-gray-700 text-xs font-semibold">
                                    <i class="fa fa-clock text-gray-400"></i> {{ format_jam($detail_data->open) }}
                                    -
                                    {{ format_jam($detail_data->close) }}
                                </h1>
                            </div>
                            <div>
                                <h1 class="text-gray-500 text-xs mb-1 font-semibold">
                                    Status
                                </h1>
                                <h1 class="text-gray-700 text-xs font-semibold">
                                    @if ($detail_data->is_active == 1)
                                        <i class="fa fa-circle text-green-500"></i> Beroprasi
                                    @else
                                        <i class="fa fa-circle  text-red-500"></i> Maintenace
                                    @endif
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="text-sm md:text-base text-justify text-gray-700 leading-normal">
                        {!! Purifier::clean($detail_data->description) !!}
                    </div>
                </div>
                <div class="w-full md:w-full">
                    <div class="flex flex-col">
                        <div class="w-full mb-3 ">
                            <img src="{{ $detail_data->getFirstMediaUrl('places-images') }}"
                                class="w-full md:h-80 object-cover rounded-md"
                                onclick="showImageModal('{{ $detail_data->getFirstMediaUrl('places-images') }}')"
                                alt="{{ $detail_data->title }}" />

                        </div>
                        {{-- <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            @foreach ($media_data as $media)
                                <div class="w-full h-40 md:h-48 cursor-pointer" onclick="showImageModal('{{ $media->getUrl() }}')">
                                    <img src="{{ $media->getUrl() }}"
                                        class="w-full h-full object-cover rounded-md hover:opacity-80 transition"
                                        alt="{{ $media->name }}">
                                </div>
                            @endforeach
                        </div> --}}
                    </div>
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
    {{-- @include('frontend.partial.service') --}}
    @include('frontend.partial.footer')
@endsection
