<div class="mb-10 shadow-lg">
    <div class="flex flex-col border rounded-md md:flex-row gap-3">
        <div class="w-full items-center  rounded-md py-3">
            <div class="mb-3 mt-2 md:mb-0">
                <h1 class="font-semibold text-sm text-center md:text-base text-gray-700">
                    Hasil Pencarian
                </h1>
            </div>
            <div class="w-full items-center flex justify-between  gap-3">
                <div class="w-full py-2 rounded-md  px-5 md:px-10 justify-center">
                    <h1 class="text-xs text-gray-500 md:text-base mb-2"><i class="fa fa-calendar"></i> Tanggal</h1>
                    <p class="text-blue-800 text-xs md:text-sm font-semibold">{{ format_tanggal($date) }}</p>
                </div>
                <div class="w-full py-2 rounded-md px-5 md:px-10">
                    <h1 class="text-xs md:text-base text-gray-500 items-center mb-2">
                        <i class="fa fa-ticket" aria-hidden="true"></i> Kategori Tiket
                    </h1>
                    <p class="text-blue-800 text-xs md:text-sm font-semibold">{{ $category }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mb-4">
    <h1 class="text-sm md:text-2xl font-semibold text-gray-700 mb-2">
        Pilihan Tiket Kamu!
    </h1>
    <h1 class="text-xs text-gray-600">
        <b class="text-blue-800">{{ count($tickets) }}</b> tiket ditemukan
    </h1>
</div>

{{-- BAGIAN TIKET --}}
<div class="flex flex-col">
    @forelse ($tickets as $item)
        <div class="w-full mb-3 border rounded-md flex justify-between py-5 px-3 align-center transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-20"
            data-ticket-id="{{ $item->id }}">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/logo.png') }}" class="w-10 h-10 rounded-full object-cover hidden md:block"
                    alt="Logo">
                <div>
                    <h2 class="font-semibold text-sm md:text-base text-gray-700">
                        {{ $item->ticket->ticket_name }}
                    </h2>
                    <p class="text-gray-500 text-xs">{{ ucfirst($item->ticket->description ?? '-') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <h1 class="text-blue-700 font-semibold">
                    Rp{{ number_format($item->price, 0, ',', '.') }}
                </h1>
                <div class="flex items-center">
                    @php
                        $cart = session('cart_tickets', []);
                        $qty = $cart[$item->id]['quantity'] ?? 0;

                    @endphp
                    <button
                        class="w-6 h-6 flex items-center justify-center bg-gray-200 rounded hover:bg-blue-700 hover:text-white btn-kurang"
                        data-ticket-id="{{ $item->id }}">-</button>
                    <input type="text" value="{{ $qty }}" readonly
                        class="w-8 h-6 text-center border rounded jumlah-tiket" />
                    <button
                        class="w-6 h-6 flex items-center justify-center bg-gray-200 rounded hover:bg-blue-700 hover:text-white btn-tambah"
                        data-ticket-id="{{ $item->id }}">+</button>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center h-48 text-gray-500  p-4 rounded-md bg-slate-50">
            <div class="flex justify-center items-center mt-10 mb-5">
                <img src="{{ asset('img/notfon.png') }}" class="w-16" alt="">
            </div>
            <div class="items-center">
                <h1 class="font-semibold">Tidak di temukan!</h1>
            </div>
        </div>
    @endforelse
</div>
