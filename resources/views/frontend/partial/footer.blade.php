<div class="bg-slate-50">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 px-4 py-8 items-start">

        <div class="md:col-span-3 mb-5 md:mb-0">
            <div class="w-full h-64 md:h-64 rounded overflow-hidden shadow-md">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.3884512693235!2d110.41630687455329!3d-7.748557876823241!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a593d9551f617%3A0x7febfde55ecd7a0e!2sWaterboom%20Jogja!5e0!3m2!1sid!2sid!4v1758647233773!5m2!1sid!2sid"
                    class="w-full h-full border-0" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-center md:text-start">
            <div class="w-full flex justify-center">
                <div>
                    <img src="{{ asset('img/logo-base.png') }}" class="w-52" alt="">
                    
                </div>
            </div>
            <div class="w-full flex gap-5">
                <div class="flex-1">
                    <h1 class="text-sm font-semibold mt-1">Tentang</h1>
                    <ul class="text-xs space-y-1">
                        @foreach (kategori_jelajah() as $item)
                            <li class="py-1 hover:text-blue-400 text-gray-600">
                                <a href="{{ route('jelajah.category', $item->slug) }}">
                                    {{ $item->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="flex-1">
                    <a href="{{ route('promo.page') }}" class="text-sm hover:text-blue-600 font-semibold">Promo</a>
                </div>

                <div class="flex-1">
                    <a href="{{ route('blog.page') }}" class="text-sm hover:text-blue-600 font-semibold">Berita</a>
                </div>

                <div class="flex-1">
                    <a href="{{ route('group.info') }}" class="text-sm hover:text-blue-600 font-semibold">Group</a>
                </div>
            </div>
        </div>

        <!-- SOSIAL MEDIA -->
        <div class="flex flex-col justify-center md:items-end items-center gap-3">
            <h1 class="text-sm font-semibold">Sosial Media</h1>
            <div class="flex gap-4">
                <a href="#" class="hover:scale-110 transition">
                    <img src="{{ asset('img/ig1.png') }}" class="w-7 h-7" alt="Instagram" />
                </a>
                <a href="#" class="hover:scale-110 transition">
                    <img src="{{ asset('img/t1.png') }}" class="w-7 h-7" alt="Tiktok" />
                </a>
                <a href="#" class="hover:scale-110 transition">
                    <img src="{{ asset('img/y1.png') }}" class="w-7 h-7" alt="youtube" />
                </a>
            </div>
        </div>

    </div>

    <!-- FOOTER BOTTOM -->
    <div class="w-full text-center bg-slate-100 border-t border-slate-200">
        <h1 class="py-3 text-xs text-slate-600">
            © 2025 Waterboom Jogja. All Rights Reserved.
        </h1>
    </div>
</div>
