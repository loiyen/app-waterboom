@if (empty($cart))
    <div class="p-16">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('img/cart.png') }}" class="object-cover w-20 h-20" alt="">
        </div>
        <div class="flex justify-center">
            <a href="{{ route('tiket.checkout') }}" class="text-center text-xs md:text-sm underline text-blue-700"><i
                    class="fa fa-refresh"></i> Reload Cart</a>
        </div>
    </div>
@else
    <div class="mb-4">
        @php $total = 0; @endphp
        @foreach ($tickets as $ticket)
            @php
                $qty = $cart[$ticket->id]['quantity'] ?? 0;
                $subtotal = $ticket->price * $qty;
                $total += $subtotal;
            @endphp
            <div
                class="w-full mb-1 rounded-md bg-slate-50 text-xs md:text-sm md:flex-row items-center flex justify-between text-gray-700 px-3 py-2 ">
                <div>
                    <h1 class="py-2 font-semibold">{{ $ticket->ticket->ticket_name ?? 'Tiket' }}</h1>
                    <p class="text-xs">( {{ $qty }} X {{ 'Rp' . number_format($ticket->price, 0, ',', '.') }} )
                    </p>
                </div>
                <h1 class="py-2">Rp{{ number_format($subtotal, 0, ',', '.') }}</h1>

            </div>
        @endforeach
    </div>
@endif

<div
    class="fixed md:static bottom-0 left-0 right-0 items-center bg-white shadow-[0_-2px_10px_rgba(0,0,0,0.1)] md:shadow-none border-t z-50 py-3 md:border-0">
    <div class="w-full text-sm md:flex-row items-center flex justify-between text-gray-700 px-4">
        <div>
            <h1 class="mt-2 mb-0 ">Total Pembayaran</h1>
            <span class="font-bold text-base ">Rp{{ number_format($total ?? 0, 0, ',', '.') }}</span>
        </div>
        <div>
            <a href="{{ route('checkout.ticket') }}"
                class="w-full text-xs md:text-sm px-10 py-3 font-semibold text-center bg-blue-700 text-white hover:bg-blue-800 rounded-lg">
                Checkout
            </a>
        </div>
    </div>
</div>
