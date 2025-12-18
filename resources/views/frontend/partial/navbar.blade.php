<div class="w-full bg-white shadow-sm md:shadow-lg top-0 left-0 right-0">

    <nav id="navbar" class="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 z-50 shadow-sm">
        {{-- <div class="w-full text-sm bg-slate-100 md:py-2">
            <div class="hidden md:flex justify-end max-w-6xl mx-auto gap-3">
                <h1 class="text-slate-500">For reservation : Waterboom@gmail.com </h1>
                <h1 class="text-slate-500">Telp : 0822-4567-8923</h1>
            </div>
        </div> --}}
        <div class="flex justify-between items-center max-w-6xl mx-auto px-4 md:px-0 py-4">
            <div class="flex items-center">
                <div class="flex ">
                    <a href="/">
                        <img src="{{ asset('img/logo.png') }}" alt="logo"
                            class="w-12 h-12 lg:w-16 lg:h-16 lg:mt-0 rounded-full object-cover " />
                    </a>
                </div>
                <span class="text-sm lg:hidden font-semibold ">
                    Hallo, Waterboomers! <br /><span class="text-xs">#Pasti Lebih Seru</span></span>
            </div>
            <!-- Menu desktop -->
            <ul class="hidden lg:flex justify-center gap-1 items-center text-gray-700 text-xs md:text-sm">
                <a href="{{ route('beranda.utama') }}">
                    <li
                        class="cursor-pointer font-semibold hover:text-white hover:bg-blue-500 py-3 px-5 hover:rounded-md">
                        Beranda
                    </li>
                </a>
                <li class="relative cursor-pointer hover:bg-blue-500 hover:text-white hover:rounded-md">
                    <button
                        class="dropdown-btn flex w-full py-3 px-5 font-semibold justify-between items-center hover:text-white"
                        data-dropdown="dropdownMenu1">
                        Jelajah
                        <i class="fa fa-chevron-down ml-2"></i>
                    </button>
                    <ul id="dropdownMenu1"
                        class="hidden absolute py-2 left-0 mt-2 w-48 md:w-48 md:text-sm bg-white shadow-lg rounded-md text-neutral-700">
                        @foreach (kategori_jelajah() as $item)
                            <a href="{{ route('jelajah.category', $item->slug) }}">
                                <li class="py-2 px-5 hover:font-semibold hover:text-blue-800 cursor-pointer">
                                    {{ $item->name }}
                                </li>
                            </a>
                        @endforeach

                    </ul>
                </li>

                {{-- tiket --}}
                {{-- <li class="relative cursor-pointer hover:bg-blue-500 hover:text-white hover:rounded-md">
                    <button
                        class="dropdown-btn w-full flex py-3 px-5 justify-between font-semibold items-center hover:text-white md:text-sm"
                        data-dropdown="dropdownMenu2">
                        Tiket & Harga
                        <i class="fa fa-chevron-down ml-2"></i>
                    </button>
                    <ul id="dropdownMenu2"
                        class="hidden absolute py-2 left-0 mt-2 w-48 md:w-56 bg-white shadow-lg rounded-md text-gray-700">
                        <a href="{{ route('tiket.checkout') }}">
                            <li class="py-2 px-5 hover:font-semibold hover:text-blue-800 cursor-pointer">
                                Tiket & Harga
                            </li>
                        </a>
                        <a href="{{ route('group.info') }}">
                            <li class="py-2 px-5 hover:font-semibold hover:text-blue-800 cursor-pointer">
                                Group
                            </li>
                        </a>
                    </ul>
                </li> --}}
                <a href="{{ route('event.page') }}">
                    <li
                        class="cursor-pointer font-semibold py-3 px-5 hover:text-white hover:bg-blue-500 hover:rounded-md">
                        Acara
                    </li>
                </a>
                <a href="{{ route('promo.page') }}">
                    <li
                        class="cursor-pointer font-semibold py-3 px-5 hover:text-white hover:bg-blue-500 hover:rounded-md">
                        Promo
                    </li>
                </a>

                <a href="{{ route('blog.page') }}">
                    <li
                        class="cursor-pointer font-semibold py-3 px-5 hover:text-white hover:bg-blue-500 hover:rounded-md">
                        Artikel & Berita
                    </li>
                </a>
                <li class="relative cursor-pointer hover:bg-blue-500 hover:text-white hover:rounded-md">
                    <button
                        class="dropdown-btn flex w-full py-3 px-5 font-semibold justify-between items-center hover:text-white"
                        data-dropdown="dropdownMenu5">
                        Tentang
                        <i class="fa fa-chevron-down ml-2"></i>
                    </button>
                    <ul id="dropdownMenu5"
                        class="hidden absolute py-2 left-0 mt-2 w-48 md:w-48 md:text-sm bg-white shadow-lg rounded-md text-neutral-700">
                        <h1 class="py-3 px-4 font-semibold text-blue-800 text-base">Waterboom</h1>
                        <li class="py-1 px-7 hover:font-semibold hover:text-blue-800 cursor-pointer">
                            <a href="{{ route('about.tentangkami') }}">
                                Tentang Kami
                            </a>
                        </li>

                        <h1 class="py-3 px-4 font-semibold text-blue-800 text-base">Reservasi</h1>
                        <li class="py-1 px-7 hover:font-semibold hover:text-blue-800 cursor-pointer">
                            <a href="{{ route('group.info') }}">
                                Group
                            </a>
                        </li>
                        <h1 class="py-3 px-4 font-semibold text-blue-800 text-base">Pengumuman </h1>
                        <li class="py-1 px-7 hover:font-semibold hover:text-blue-800 cursor-pointer">
                            <a href="{{ route('about.careers') }}">
                                Careers
                            </a>
                        </li>

                    </ul>
                </li>
                {{-- <a href="{{ route('group.info') }}">
                    <li
                        class="cursor-pointer font-semibold py-3 px-5 hover:text-white hover:bg-blue-500 hover:rounded-md">
                        Group
                    </li>
                </a> --}}

                {{-- user --}}
                {{-- <li class="relative cursor-pointer justify-end ">
                    <button
                        class="dropdown-btn w-full flex py-3 px-5 justify-between font-semibold items-center hover:text-blue-700 md:text-sm"
                        data-dropdown="dropdownMenu6">
                        <i class="fa fa-user"></i>
                    </button>
                    <ul id="dropdownMenu6"
                        class="hidden absolute py-2 left-0 mt-2 w-48 md:w-56 bg-white shadow-lg rounded-md text-gray-700">
                        <li class="px-5 py-2">
                            <div class="flex items-center gap-3">
                                <div class="rounded-full border shadow-md py-3 px-4">
                                    <h1 class="text-blue-700">HI</h1>
                                </div>
                                <div class="text-xs">
                                    <h1 class="font-semibold">Moskop</h1>
                                    <h1 class="text-gray-500">082250590837</h1>
                                </div>
                            </div>
                        </li>
                        <li class="px-5 py-2 ml-3 hover:font-semibold hover:text-blue-800 cursor-pointer">
                            <a href="{{ route('history.buy') }}">
                                Riwayat
                            </a>
                        </li>
                        <a href="{{ route('logout.user') }}">
                            <li class="px-5 py-2 ml-3 hover:font-semibold hover:text-blue-800 cursor-pointer">
                                Keluar
                            </li>
                        </a>

                    </ul>
                </li> --}}

            </ul>
            <div class="w-96 hidden lg:flex justify-end overflow-visible">
                <div class="relative w-full">
                    <input
                        class="w-full pl-10 pr-4 py-2 text-sm rounded-md border shadow-sm text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        id="searchInput" type="text" placeholder="Masukan Pencarian..." />
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fa fa-search"></i>
                    </span>

                    <div id="searchResults"
                        class="absolute hidden bg-white border w-full mt-1 rounded-md shadow-lg max-h-64 overflow-y-auto z-50 text-sm">
                    </div>
                </div>
            </div>


            <!-- Hamburger mobile -->
            <div class="lg:hidden">
                <div>
                    <button id="hamburger" onclick="toggleMenu()"
                        class="lg:hidden px-3 py-2 rounded-lg focus:outline-none">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- mobile-menu -->
    <div id="mobileMenu"
        class="hidden fixed top-14 left-0 right-0 bg-white text-sm shadow-md overflow-y-auto h-screen z-40 transition-all duration-1000">
        <div class="p-5">
            <div class="mb-5 mt-5">
                <label class="text-xs py-2 block">Pencarian :</label>
                <input id="searchInputMobile" type="text"
                    class="text-sm  border shadow-sm text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none w-full px-3 py-3 rounded-lg"
                    placeholder="Masukan kata kunci..." />
                <div id="searchResultsMobile"
                    class="absolute hidden bg-white border w-full mt-1 rounded-md shadow-lg max-h-64 overflow-y-auto z-50 text-sm">
                </div>
            </div>
            {{-- user --}}
            {{-- <div class="mb-3 border py-3 px-5 shadow-md rounded-lg">
                <div class="flex justify-between items-center">
                    <div class="flex justify-center gap-3 items-center text-xs ">
                        <div class="rounded-full border shadow-md py-3 px-4">
                            <h1 class="text-blue-700">HI</h1>
                        </div>
                        <div class="">
                            <h1 class="text-gray-700 font-semibold">Moskop</h1>
                            <h1 class="text-gray-500">082250590827</h1>
                        </div>
                    </div>
                    <div>
                        <button class="dropdown-btn w-full flex justify-between items-center"
                            data-dropdown="dropdownMenu3">
                            <i class="fa fa-chevron-down text-xs ml-2 text-gray-700"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <ul id="dropdownMenu3" class="hidden mt-2 ml-3 text-xs text-gray-600">
                        <a href="{{ route('history.buy') }}">
                            <li class="py-2 px-2 hover:text-blue-800 hover:font-semibold cursor-pointer">
                                Riwayat
                            </li>
                        </a>
                        <a href="{{ route('logout.user') }}">
                            <li class="py-2 px-2 hover:text-blue-800 hover:font-semibold cursor-pointer">
                                Keluar
                            </li>
                        </a>
                    </ul>
                </div>
            </div> --}}


            <ul class="text-gray-700 text-xs">
                <a href="{{ route('beranda.utama') }}">
                    <li class="border font-semibold py-4 px-5 hover:text-blue-800 cursor-pointer">
                        Beranda
                    </li>
                </a>

                <li class="border py-4 px-5 hover:text-blue-800">
                    <button class="dropdown-btn w-full font-semibold flex justify-between items-center"
                        data-dropdown="dropdownMenu4">
                        Jelajah
                        <i class="fa fa-chevron-down ml-2"></i>
                    </button>
                    <ul id="dropdownMenu4" class="hidden mt-2 ml-3 text-gray-700">
                        @foreach (kategori_jelajah() as $item)
                            <a href="{{ route('jelajah.category', $item->slug) }}">
                                <li class="py-3 px-5 hover:font-semibold hover:text-blue-800 cursor-pointer">
                                    {{ $item->name }}
                                </li>
                            </a>
                        @endforeach

                    </ul>
                </li>

                {{-- <li class="border py-3 px-5">
                    <button class="dropdown-btn w-full flex font-semibold justify-between items-center"
                        data-dropdown="dropdownMenu5">
                        Tiket & Harga
                        <i class="fa fa-chevron-down ml-2"></i>
                    </button>
                    <ul id="dropdownMenu5" class="hidden mt-2 ml-3 text-gray-700">
                        <a href="{{ route('tiket.checkout') }}">
                            <li class="py-2 px-2 hover:text-blue-800 hover:font-semibold">
                                Tiket & Harga
                            </li>
                        </a>
                        <a href="buy-tickets-group.html">
                            <a href="{{ route('group.info') }}">
                                <li class="py-2 px-2 hover:text-blue-800 hover:font-semibold">
                                    Group
                                </li>
                            </a>
                        </a>
                    </ul>
                </li> --}}
                <a href="{{ route('event.page') }}">
                    <li class="border font-semibold py-4 px-5 hover:text-blue-800 cursor-pointer">
                        Acara
                    </li>
                </a>
                <a href="{{ route('promo.page') }}">
                    <li class="border font-semibold py-4 px-5 hover:text-blue-800 cursor-pointer">
                        Promo
                    </li>
                </a>
                <a href="{{ route('blog.page') }}">
                    <li class="border font-semibold py-4 px-5 hover:text-blue-800 cursor-pointer">
                        Artikel & Berita
                    </li>
                </a>
                <li class="border py-4 px-5 hover:text-blue-800">
                    <button class="dropdown-btn w-full font-semibold flex justify-between items-center"
                        data-dropdown="dropdownMenu6">
                        Tentang
                        <i class="fa fa-chevron-down ml-2"></i>
                    </button>
                    <ul id="dropdownMenu6" class="hidden mt-2 ml-3 text-gray-700">
                        <a href="{{ route('about.tentangkami') }}">
                            <li class="py-3 px-2 hover:text-blue-800 hover:font-semibold cursor-pointer">
                                Tentang Kami
                            </li>
                        </a>
                        <a href="{{ route('group.info') }}">
                            <li class="py-3 px-2 hover:text-blue-800 hover:font-semibold cursor-pointer">
                                Group
                            </li>
                        </a>
                        <a href="{{ route('about.careers') }}">
                            <li class="py-3 px-2 hover:text-blue-800 hover:font-semibold cursor-pointer">
                                Careers
                            </li>
                        </a>

                    </ul>
                </li>

            </ul>

            <div class="flex justify-center gap-2 py-5 mb-10">
                <a href="https://www.waterboomjogja.com/p/tiket-promo-online-waterboom-jogja.html?m=1"
                    class="bg-blue-700 text-center text-xs w-full py-3 px-2 rounded-md text-white hover:font-semibold">
                    Pesan Tiket!
                </a>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function setupSearch(inputId, resultsId) {
                const $input = $(inputId);
                const $results = $(resultsId);

                $input.on('keyup', function() {
                    const query = $(this).val().trim();

                    if (query.length < 2) {
                        $results.addClass('hidden').html('');
                        return;
                    }

                    $.ajax({
                        url: "{{ route('search.global') }}",
                        method: 'GET',
                        data: {
                            q: query
                        },
                        success: function(response) {
                            let html = '';

                            if (
                                response.place.length === 0 &&
                                response.blog.length === 0 &&
                                response.promo.length === 0
                            ) {
                                html =
                                    '<p class="text-gray-500 text-center p-3">Tidak ada hasil ditemukan</p>';
                            } else {

                                if (response.place.length > 0) {
                                    html +=
                                        '<h2 class="font-bold text-sm mt-2 mb-1 px-3 text-gray-600">Tempat</h2>';
                                    response.place.forEach(place => {
                                        html += `<div class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                    <a href="/jelajah/detail/${place.slug}" class="block text-sm text-gray-700">
                                        🏞️ ${place.name}
                                    </a>
                                </div>`;
                                    });
                                }

                                if (response.promo.length > 0) {
                                    html +=
                                        '<h2 class="font-bold text-sm mt-2 mb-1 px-3 text-gray-600">Promo</h2>';
                                    response.promo.forEach(promo => {
                                        html += `<div class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                    <a href="/detail-promo/${promo.slug}" class="block text-sm text-gray-700">
                                        🎟️ ${promo.title}
                                    </a>
                                </div>`;
                                    });
                                }

                                if (response.blog.length > 0) {
                                    html +=
                                        '<h2 class="font-bold text-sm mt-2 mb-1 px-3 text-gray-600">Berita</h2>';
                                    response.blog.forEach(blog => {
                                        html += `<div class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                    <a href="/blog-detail/${blog.slug}" class="block text-sm text-gray-700">
                                        📰 ${blog.title}
                                    </a>
                                </div>`;
                                    });
                                }
                            }

                            $results.removeClass('hidden').html(html);
                        },
                        error: function() {
                            $results.html(
                                '<p class="text-red-500 text-center p-3">Terjadi kesalahan.</p>'
                            );
                        }
                    });
                });


                $(document).on('click', function(e) {
                    if (!$(e.target).closest(inputId + ', ' + resultsId).length) {
                        $results.addClass('hidden');
                    }
                });
            }

            setupSearch('#searchInput', '#searchResults');
            setupSearch('#searchInputMobile', '#searchResultsMobile');
        });
    </script>





</div>
