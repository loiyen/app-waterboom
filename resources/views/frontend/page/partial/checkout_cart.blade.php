<div class="mb-4 md:mb-7">
    <h1 class="text-sm mb- md:text-base font-semibold text-gray-700">Item yang dibeli
        ({{ $total_qty }})
    </h1>
</div>

@foreach ($tickets as $item)
    @php
        $qty = $cart[$item->id]['quantity'] ?? 0;
        $total = $qty * $item->price;
    @endphp

    <div class="cart-item border w-full mb-2 bg-slate-50 rounded-md text-xs md:text-sm flex justify-between items-center text-gray-700 px-3 py-2"
        data-ticket-id="{{ $item->id }}">
        <div>
            <h1 class="py-2 font-semibold">{{ $item->ticket->ticket_name }}</h1>
            <p class="text-xs">
                ( {{ $qty }} x Rp{{ number_format($item->price, 0, ',', '.') }})
            </p>
        </div>
        <h1 class="py-2">Rp{{ number_format($total, 0, ',', '.') }}</h1>
        <div class="flex items-center space-x-1">
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
@endforeach
