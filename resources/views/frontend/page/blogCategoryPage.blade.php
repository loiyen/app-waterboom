@extends('frontend.layout.main')

@section('container')
    @include('frontend.partial.navbar')

    <div class="container mx-auto max-w-6xl md:mt-32 mt-24 mb-10">
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
                <i class="fa fa-angle-right text-gray-400 px-2"></i> {{ $title }}
            </h1>
        </div>
    </div>

    <div class="container mx-auto max-w-6xl mb-10 px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            @forelse ($data_category as $news)
                <div class="mb-5 rounded-md shadow-md flex flex-col justify-between">
                    <div class="w-full h-auto overflow-hidden relative group">
                        <img src="{{ asset('img/1.png') }}"
                            class="w-full h-full rounded-t-lg transition-transform duration-500 group-hover:scale-110"
                            alt="">
                    </div>

                    <div class="p-6 mt-auto">
                        <a href="{{ route('detail.blog', $news->slug) }}">
                            <h1 class="text-lg text-gray-700 hover:text-blue-700 font-semibold">
                                {{ $news->title }}
                            </h1>
                        </a>

                        <p class="text-sm py-3 text-gray-600">
                            {{ $news->summary }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center col-span-4 text-gray-500  p-20 rounded-md bg-slate-50">
                    <div class="flex justify-center items-center mt-10 mb-5">
                        <img src="{{ asset('img/notfon.png') }}" class="w-16" alt="">
                    </div>
                    <div class="items-center">
                        <h1 class="font-semibold">Tidak di temukan!</h1>
                    </div>
                </div>
            @endforelse
        </div>
        @if ($data_category->hasPages())
            <div class="mt-6 hover:text-blue-700">
                {{ $data_category->links('pagination::tailwind') }}
            </div>
        @endif
    </div>

    @include('frontend.partial.footer')
@endsection
