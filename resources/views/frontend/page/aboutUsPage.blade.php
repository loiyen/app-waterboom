@extends('frontend.layout.main')

@section('container')
    @include('frontend.partial.navbar')

    <div class="container mx-auto max-w-6xl lg:mt-32 mt-24 mb-10">
        {{-- <div class="mb-5">
            <img src="{{ asset('img/water1.jpeg') }}" class="w-full md:h-80 object-cover" alt="" />
        </div> --}}
        <div class="text-start px-4 flex justify-center md:justify-start text-gray-700">
            <a href="/">
                <h1 class="hover:text-blue-700 text-xs cursor-pointer">Beranda</h1>
            </a>
            <h1 class="text-xs font-semibold">
                <i class="fa fa-angle-right text-gray-400 px-2"></i> Tentang Kami
            </h1>
        </div>
    </div>

    <div class="container mx-auto max-w-6xl mb-10 px-4">
        <div class="mb-10">
            <h1 class="text-2xl md:text-3xl text-start font-bold text-gray-700">
                <span class="text-blue-700">Waterboom</span> {{ $waterboom->title ?? '' }}
            </h1>
        </div>
        <div class="flex flex-col md:flex-row justify-between gap-5 text-sm md:text-base text-gray-700 mb-16"
            data-aos="fade-up" data-aos-anchor-placement="top-center">
            <div class="w-full text-justify">
                <h1> {!! Purifier::clean($waterboom->content ?? '') !!}</h1>
            </div>
            <div class="w-full md:w-2/3">
                @if ($waterboom && $waterboom->image)
                    <img src="{{ asset('storage/' . $waterboom->image) }}"
                        class="object-cover w-full h-full rounded-md shadow-md" alt="">
                @endif

            </div>
        </div>

        @if ($visi)
            <div data-aos="fade-up" data-aos-anchor-placement="top-center">
                <div class="mb-5 text-sm md:text-2xl">
                    <h1 class="font-bold text-center md:text-start text-gray-700">
                        {{ $visi->title }} & Misi Waterboom Jogja
                    </h1>
                </div>

                <div class="flex flex-col md:flex-row justify-between gap-10 text-sm md:text-base text-gray-700 mb-16">
                    <div class="w-full md:w-2/3">
                        <img src="{{ asset('storage/' . ($visi->image ?? 'default.png')) }}"
                            class="object-cover rounded-md shadow-md" alt="">
                    </div>

                    <div class="w-full text-justify">
                        <h1 class="mb-2 font-semibold text-center">
                            {!! Purifier::clean($visi->content ?? '') !!}
                        </h1>

                        @if ($misi)
                            <div>
                                <h1>{!! Purifier::clean($misi->content ?? '') !!}</h1>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @if ($feature)
            <div data-aos="fade-up" data-aos-anchor-placement="top-center">
                <div class="mb-5 text-sm md:text-2xl">
                    <h1 class="font-bold text-center md:text-start text-gray-700">
                        {{ $feature->title }}
                    </h1>
                </div>

                <div class="flex flex-col md:flex-row justify-between gap-5 text-sm md:text-base text-gray-700 mb-16">
                    <div class="w-full text-justify">
                        <h1>{!! Purifier::clean($feature->content ?? '') !!}</h1>
                    </div>

                    <div class="w-full md:w-2/3">
                        <img src="{{ asset('storage/' . ($feature->image ?? 'default.png')) }}"
                            class="object-cover rounded-md shadow-md" alt="">
                    </div>
                </div>
            </div>
        @endif

        <div class="mb-5" data-aos="fade-up" data-aos-anchor-placement="top-center">
            <div class="mb-10">
                <h1 class="text-2xl md:text-2xl text-start font-bold text-gray-700">
                    <span class="text-blue-700">Partner</span> Waterboom Jogja
                </h1>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg::grid-cols-2 justify-center gap-2">
                @forelse ($partner as $item)
                    <div class="w-full flex justify-center">
                        <img src="{{ asset('storage/' . $item->image) }}" class="w-24 md:w-32 h-auto object-contain "
                            alt="" />
                    </div>
                @empty
                    <div class="col-span-4 text-center bg-gray-100 text-gray-500  p-20 rounded-md">
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

    </div>

    @include('frontend.partial.footer')
@endsection
