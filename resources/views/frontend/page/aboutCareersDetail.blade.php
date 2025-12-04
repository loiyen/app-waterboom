@extends('frontend.layout.main')

@section('container')
    @include('frontend.partial.navbar')

    <div class="container mx-auto max-w-6xl lg:mt-32 mt-20 mb-10">
        <div class="mb-5">
            <img src="{{ asset('storage/' . $detail_loker->image) }}" class="w-full md:h-80 object-cover" alt="" />
        </div>
        <div class="text-start px-4 flex justify-center md:justify-start text-gray-700">
            <h1 class="hover:text-blue-700 text-xs cursor-pointer">Beranda</h1>
            <a href="{{ route('about.careers') }}">
                <h1 class="text-xs font-semibold">
                    <i class="fa fa-angle-right text-gray-400 px-2"></i> Careers
                </h1>
            </a>
            <h1 class="text-xs font-semibold">
                <i class="fa fa-angle-right text-gray-400 px-2"></i> Detail
            </h1>
        </div>
    </div>

    <div class="container mx-auto max-w-6xl mb-10 px-4">
        <div class="mb-5">
            <h1 class="text-2xl md:text-3xl py-3 text-start font-bold text-gray-700">
                {{ $detail_loker->position }}
            </h1>
        </div>
        <div class="flex gap-5">
            <div class="border p-3 rounded-lg flex items-center gap-2 w-44 mb-10">
                <i class="fa fa-check-square text-xs text-green-500"></i>
                <h1 class="text-gray-500 text-xs">{{ $detail_loker->department }}</h1>
            </div>
            <div class="border p-3 rounded-lg flex items-center gap-2 w-44 mb-10">
                <i class="fa fa-check-square text-xs text-green-500"></i>
                <h1 class="text-gray-500 text-xs">{{ $detail_loker->job_type }}</h1>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3   gap-4">
            <div class="border rounded-md w-full shadow-md p-6">
                <div class="mb-4">
                    <h1 class="text-center font-semibold text-gray-700 text-sm md:text-base">Deskripsi Perkerjaan</h1>
                </div>
                <div class="text-justify text-sm text-gray-500">
                    <p class="">{!! Purifier::clean($detail_loker->description) !!}</p>
                </div>
            </div>
            <div class="border rounded-md w-full shadow-md p-6">
                <div class="mb-4">
                    <h1 class="text-center font-semibold text-gray-700 text-sm md:text-base">Persyaratan</h1>
                </div>
                <div class="text-justify text-sm text-gray-500">
                    <dp class="">{!! Purifier::clean($detail_loker->requirements) !!}</dp>
                </div>
            </div>
            <div class="border rounded-md  w-full shadow-md p-6">
                <div class="mb-4">
                    <h1 class="text-center font-semibold text-gray-700 text-sm md:text-base">Timeline</h1>
                </div>
                <div class="flex justify-between mb-5">
                    <div class="py-1  text-sm text-gray-500">
                        <p class="text-xs mb-1">Pendaftaran </p>
                        <p class="font-semibold"> {{ format_tanggal(now()) }}</p>
                    </div>
                    <div class="py-1  text-sm text-gray-500">
                        <p class="text-xs mb-1">Sampai </p>
                        <p class="font-semibold"> {{ format_tanggal($detail_loker->deadline) }}</p>
                    </div>
                </div>
                <div class="border rounded-md p-3 text-sm text-gray-500 mb-5">
                    <p class="text-xs mb-2">Interview</p>
                    <p><i class="fa fa-map-marker"></i> Gedung M1 lantai 2 Waterboom Jogja</p>
                    <p>Jln. Jenengan, Maguwoharjo, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta</p>
                </div>
                <div class="border rounded-md p-3 text-sm text-gray-500 mb-10">
                    <p class="text-xs mb-2">Lamaran</p>
                    <div class="flex py-1 justify-between">
                        <h1><i class="fa fa-envelope"></i> Email</h1>
                        <h1>hrd@waterboom.com</h1>
                    </div>
                    <div class="flex py-1 justify-between">
                        <h1><i class="fa fa-phone"></i> Telefon</h1>
                        <h1>0822-3422-2345</h1>
                    </div>
                </div>
                <div class="p-3 text-sm text-gray-500 ">
                    <a href="mailto:hrd@waterboom.com?subject=Lamaran%20Pekerjaan&body=Halo,%20saya%20ingin%20melamar..."
                        class="block border rounded-md hover:bg-blue-700 hover:text-white p-3 text-sm text-gray-500 text-center">
                        Kirim Lamaran
                    </a>

                </div>
            </div>
        </div>
    </div>
    @include('frontend.partial.footer')
@endsection
