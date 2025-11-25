@extends('frontend.layout.main')

@section('container')
    @include('frontend.partial.navbar')

    <div class="container mx-auto max-w-6xl lg:mt-18 sm:mt-16 mb-10">
        <div class="mb-5">
            <img src="{{ asset('img/water1.jpeg') }}" class="w-full md:h-80 object-cover" alt="" />
        </div>
        <div class="mb-5 px-4 flex justify-center md:justify-start text-gray-700">
            <h1 class="hover:text-blue-700 text-xs cursor-pointer">Beranda</h1>
            <h1 class="text-xs font-semibold">
                <i class="fa fa-angle-right text-gray-400 px-2"></i> Wahana
            </h1>
        </div>
    </div>

    <div class="container mx-auto max-w-6xl mb-10 px-4">
        <div class="mb-5">
            <h1 class="text-2xl md:text-3xl py-3 text-start font-bold text-gray-700">
                <span class="text-blue-700">{{ $kategori->name }}</span> Waterboom
            </h1>
        </div>
        <!-- Subjudul -->
        <div class="text-sm md:text-base mb-5 text-gray-600">
            {{ $kategori->description }}
        </div>
        <div class="">
            <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center mb-10">
                <h1 class="font-semibold text-xs md:text-sm text-gray-700 mb-3 md:mb-0"> {{ $total }} {{ $kategori->name }}
                </h1>
                <div class="relative w-full md:w-96">
                    <input
                        class="w-full pl-10 pr-4 py-2 rounded-md border text-xs md:text-sm shadow-sm text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        id="search-input" type="text" placeholder="Cari di kategori {{ $kategori->name }}..." />
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fa fa-search"></i>
                    </span>
                </div>
            </div>

            <!-- show-wahana -->
            <div id="explor-container" class="mb-10">
                @include('frontend.page.partial.explor_list', ['places' => $places])
            </div>

        </div>
    </div>

    <script>
        const resultList = document.getElementById('explor-container');
        const searchInput = document.getElementById('search-input');
        const slug = "{{ $kategori->slug }}";

        let currentQuery = '';
        let currentPage = 1;

        function fetchData(query = '', page = 1) {
            fetch(`/jelajah/${slug}/search?q=${encodeURIComponent(query)}&page=${page}`)
                .then(res => res.text())
                .then(html => {
                    resultList.innerHTML = html;
                    attachPaginationLinks(); 
                })
                .catch(err => console.error(err));
        }
        searchInput.addEventListener('keyup', function() {
            currentQuery = this.value;
            currentPage = 1;
            fetchData(currentQuery, currentPage);
        });

        function attachPaginationLinks() {
            const links = resultList.querySelectorAll('#pagination-links a');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = new URL(this.href);
                    const page = url.searchParams.get('page') || 1;
                    currentPage = page;
                    fetchData(currentQuery, currentPage);
                });
            });
        }

        attachPaginationLinks();
    </script>

    @include('frontend.partial.service')
    @include('frontend.partial.footer')
@endsection
