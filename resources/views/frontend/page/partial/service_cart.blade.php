@forelse ($cart_service as $id => $cart)
    @php
        $item = $servicesCart->firstWhere('id', $id);
        $qty = $cart['quantity'];
    @endphp

    <div
        class="w-full mb-2 border bg-slate-50 rounded-md text-xs md:text-sm flex justify-between items-center text-gray-700 px-3 py-2">
        <div>
            <h1 class="font-semibold mb-2">{{ $item->name }}</h1>
            <h1 class="text-gray-700">( {{ $qty }} X Rp{{ number_format($item->price, 0, ',', '.') }} )</h1>
        </div>
        <h1 class="py-2">Rp{{ number_format($item->price * $qty, 0, ',', '.') }}</h1>
        <form class="form-delete-service" data-service-id="{{ $item->id }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="py-2 px-3 text-sm cursor-pointer hover:text-red-700">
                <i class="fa fa-minus-circle"></i>
            </button>
        </form>
    </div>
@empty
    <div class="p-14 md:p-0">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('img/cart.png') }}" class="object-cover w-20 h-20" alt="">
        </div>
        <div class="flex justify-center">
            <a href="{{ route('checkout.ticket') }}" class="text-center text-xs md:text-sm underline text-blue-700"><i
                    class="fa fa-refresh"></i> Reload Cart</a>
        </div>

    </div>
@endforelse
