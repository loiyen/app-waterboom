@extends('frontend.layout.main')

@section('container')
    @include('frontend.partial.navbar')

    <div class="container mx-auto max-w-6xl lg:mt-32 mt-16 mb-10">
        <div class="mb-5">
            <img src="{{ asset('storage/'.$banner->first()->image) }}" class="w-full md:h-80 object-cover" alt="" />
        </div>
        <div class="text-start px-4 flex justify-center md:justify-start text-gray-700">
            <a href="/">
                <h1 class="hover:text-blue-700 text-xs cursor-pointer">Beranda</h1>
            </a>
            <h1 class="text-xs font-semibold">
                <i class="fa fa-angle-right text-gray-400 px-2"></i> Promo
            </h1>
        </div>
    </div>

    <div class="container mx-auto max-w-6xl mb-10 px-4">
        <div class="mb-5">
            <h1 class="text-2xl md:text-3xl text-start font-bold text-gray-700">
                <span class="text-blue-700">Promo</span> Waterboom
            </h1>
        </div>
        <div class="text-sm md:text-base mb-5 text-gray-600">
            <p>Temukan berbagai promo menarik di Waterboom hanya untukmu!</p>
        </div>
        <div class="flex flex-wrap gap-3 text-sm md:text-base font-medium mb-10">
            <div class="flex justify-center gap-3 mb-6">
                <button
                    class="filter-btn flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white px-5 py-2 rounded-full shadow-lg hover:from-white hover:to-white hover:text-blue-600 hover:border-blue-600 border transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105  {{ $status == 'all' ? 'bg-blue-500 text-white' : '' }}"
                    data-status="all">
                    Semua <span class="font-semibold text-sm"> {{ $totalAll }}</span>
                </button>
                <button
                    class="filter-btn flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white px-5 py-2 rounded-full shadow-lg hover:from-white hover:to-white hover:text-blue-600 hover:border-blue-600 border transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 {{ $status == 'tiket' ? 'bg-blue-500 text-white' : '' }}"
                    data-status="tiket">
                    Tiket <span class="font-semibold text-sm"> {{ $countByCategory['tiket'] ?? 0 }}</span>
                </button>
                <button
                    class="filter-btn flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white px-5 py-2 rounded-full shadow-lg hover:from-white hover:to-white hover:text-blue-600 hover:border-blue-600 border transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 {{ $status == 'resto' ? 'bg-blue-500 text-white' : '' }}"
                    data-status="resto">
                    Resto <span class="font-semibold text-sm"> {{ $countByCategory['resto'] ?? 0 }}</span>
                </button>
            </div>
        </div>
        <div class="">
            <div class="flex flex-col md:flex-row justify-start md:justify-end md:items-center mb-10">
                <div class="relative w-full md:w-96">
                    <input id="search-input"
                        class="search-input text-xs md:text-sm w-full pl-10 pr-4 py-2 rounded-md border shadow-sm text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        type="text" placeholder="Cari Promo..." />
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fa fa-search"></i>
                    </span>
                </div>
            </div>
            <div id="promo-container">
                @include('frontend.page.partial.promo_list', [
                    'promos' => $promos,
                ])
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const promoContainer = document.querySelector('#promo-container');
            const buttons = document.querySelectorAll('.filter-btn');
            const searchInput = document.querySelector('#search-input');

            function fetchPromos(status = 'all', search = '') {
                promoContainer.innerHTML = `
            <div class="text-center py-10 text-gray-500">
                <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500 mx-auto mb-3"></div>
                Memuat promo...
            </div>
        `;
                fetch(`/promo?status=${status}&search=${encodeURIComponent(search)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.text())
                    .then(html => {
                        promoContainer.innerHTML = html;

                        buttons.forEach(btn => btn.classList.remove('bg-blue-500', 'text-white'));
                        document.querySelector(`[data-status="${status}"]`)?.classList.add('bg-blue-500',
                            'text-white');
                    })
                    .catch(err => {
                        promoContainer.innerHTML =
                            `<p class="text-center text-red-500 mt-10">Gagal memuat data</p>`;
                        console.error(err);
                    });
            }

            buttons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const status = btn.dataset.status;
                    fetchPromos(status, searchInput.value);
                });
            });

            let timer;
            searchInput.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    const activeStatus = document.querySelector('.filter-btn.bg-blue-500')?.dataset
                        .status || 'all';
                    fetchPromos(activeStatus, searchInput.value);
                }, 500);
            });
        });
    </script>

    @include('frontend.partial.service')
@endsection
