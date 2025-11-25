@extends('frontend.layout.main')

@section('container')
    @include('frontend.partial.navbar')

    <div class="container mx-auto max-w-6xl lg:mt-32 sm:mt-16 mb-10">
        <div class="mb-5">
            @if ($images)
                <img src="{{ asset('storage/' . $images->image) }}" class="w-full md:h-80 object-cover" alt="">
            @else
                <p>Tidak ada gambar ditemukan.</p>
            @endif
        </div>
        <div class="text-start px-4 flex justify-center md:justify-start text-gray-700">
            <a href="/">
                <h1 class="hover:text-blue-700 hover:underline text-xs cursor-pointer">Beranda</h1>
            </a>
            <h1 class="text-xs font-semibold">
                <i class="fa fa-angle-right text-gray-400 px-2"></i> Tiket
            </h1>
        </div>
    </div>

    <div class="container mx-auto max-w-6xl mb-10 px-4">
        <div class="mb-5 md:mb-10">
            <div class="mb-5">
                <h1 class="text-2xl md:text-3xl mb-5 text-start font-bold text-gray-700">
                    <b class="text-blue-700">Tiket Reguler</b> Waterboom Jogja
                </h1>
            </div>

            <div class="cursor-pointer mb-10">
                <div
                    class="flex shadow-md justify-between text-xs md:text-base mb-3 font-semibold text-white border rounded-md bg-gradient-to-r from-blue-700 to-blue-400 py-3 px-3">
                    <h1>Buka hari ini, 09 : 00 - 16 : 00</h1>
                    <h1 class="">
                        <i class="fa fa-angle-right text-white px-2"></i>
                    </h1>
                </div>
            </div>
            <div class="flex flex-col md:flex-row justify-between gap-3">
                <div class="w-full mb-3 md:mb-0 items-center rounded-md border gap-3 flex py-2 px-3">
                    <div>
                        <h1 class="px-1 text-lg md:text-2xl mt-5">
                            <i class="fa fa-sign-in text-blue-700"></i>
                        </h1>
                    </div>
                    <div class="w-full mb-4">
                        <label for="visit-date" class="block text-xs md:text-base text-gray-700 font-semibold mb-2">
                            Tanggal Kunjungan
                        </label>
                        <input type="text" id="visit-date" placeholder="Pilih Tanggal"
                            class="w-full cursor-pointer rounded-lg border border-gray-300 px-3 py-2 text-gray-700 text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    </div>
                </div>
            </div>
        </div>

        <div class="pb-20 md:pb-0">
            <div class="flex flex-col md:flex-row gap-6">
                <div id="result"
                    class="w-full h-full text-xs md:text-base md:w-2/3 flex flex-col mb-2 md:mb-0 rounded-md">
                    @include('frontend.page.partial.ticket-list', [
                        'tickets' => $tickets,
                        'date' => $date,
                        'category' => $category,
                    ])
                </div>
                <div class="w-full h-full md:w-96 border rounded-md shadow-sm">
                    <div class="flex justify-between items-center py-3">
                        <div>
                            <h1
                                class="text-sm md:text-base text-start md:text-center font-semibold text-gray-700 py-3 px-3">
                                Tiket yang dipilih
                            </h1>
                        </div>
                        <div class="px-3">
                            <form action="{{ route('destroy.cart') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn-delete text-xs md:text-sm py-2 px-3 border rounded-full hover:font-semibold hover:bg-red-700 hover:text-white">
                                    <i class="fa fa-trash" aria-hidden="true"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    <hr />
                    <div class="flex flex-col justify-between px-2 mt-2 ">
                        <div id="cart-container">
                            @include('frontend.page.partial.cart-list', [
                                'cart' => $keranjang,
                                'tickets' => \App\Models\TicketPrices::whereIn('id', array_keys($keranjang))->with('ticket')->get(),
                            ])
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    {{-- <script>
        $(document).ready(function() {
            $('#visit-date').on('change', function() {
                const date = $(this).val();
                if (!date) return;

                $.ajax({
                    url: "{{ route('tickets.byDate') }}",
                    method: "GET",
                    data: {
                        date: date
                    },
                    beforeSend: function() {
                        $('#result').addClass('opacity-50 pointer-events-none');
                        $('#loading').removeClass('hidden');
                    },
                    success: function(response) {
                        $('#result').html(response);
                        history.pushState(null, '', '?date=' + date);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    },
                    complete: function() {

                        $('#loading').addClass('hidden');
                        $('#result').removeClass('opacity-50 pointer-events-none');
                        $('#ticket-container').removeClass('opacity-50');
                        $('#ticket-container').css('pointer-events', 'auto');
                    }
                });
            });
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            $('#visit-date').on('change', function() {
                const date = $(this).val();
                if (!date) return;

                $.ajax({
                    url: "{{ route('tickets.clearCart') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $('#result').html(`
                                <div class="flex justify-center py-10">
                                    <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500"></div>
                                    </div>
                                     <p class="text-center text-gray-500 mt-3">Memuat data...</p>
                            `);
                        $('#cart-container').addClass('opacity-50 pointer-events-none');
                    },

                    success: function() {
                        $.ajax({
                            url: "{{ route('tickets.byDate') }}",
                            method: "GET",
                            data: {
                                date: date
                            },
                            success: function(response) {
                                $('#result').html(response);
                                refreshCart();
                                history.pushState(null, '', '?date=' + date);
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal memuat tiket baru',
                                    text: 'Terjadi kesalahan saat mengambil data tiket.',
                                    timer: 2000,
                                    showConfirmButton: false,
                                    position: 'top-end',
                                    toast: true
                                });
                            },
                            complete: function() {
                                $('#result').removeClass(
                                    'opacity-50 pointer-events-none');
                                $('#cart-container').removeClass(
                                    'opacity-50 pointer-events-none');
                            }
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal menghapus keranjang',
                            text: 'Terjadi kesalahan saat membersihkan data.',
                            timer: 2000,
                            showConfirmButton: false,
                            position: 'top-end',
                            toast: true
                        });
                    }
                });
            });
        });
    </script>

    <script>
        const MAX_QTY = 15;

        $(document).on('click', '.btn-tambah', function() {
            const card = $(this).closest('.border');
            const input = card.find('.jumlah-tiket');
            let jumlah = parseInt(input.val()) || 0;

            if (jumlah < MAX_QTY) {
                jumlah++;
                input.val(jumlah);

                const ticketId = card.data('ticket-id');
                updateTiket(ticketId, jumlah);
            } else {

                Swal.fire({
                    icon: 'warning',
                    title: 'Maksimal tercapai',
                    text: 'Kamu hanya bisa membeli maksimal!' + MAX_QTY + ' tiket per jenis.',
                    timer: 1500,
                    showConfirmButton: false,
                    position: 'top-end',
                    toast: true
                });
            }
        });

        $(document).on('click', '.btn-kurang', function() {
            const card = $(this).closest('.border');
            const input = card.find('.jumlah-tiket');
            let jumlah = parseInt(input.val()) || 0;
            if (jumlah > 0) jumlah--;
            input.val(jumlah);

            const ticketId = card.data('ticket-id');
            updateTiket(ticketId, jumlah);
        });

        function refreshCart() {
            $.get("{{ route('tickets.getCart') }}", function(data) {
                $('#cart-container').html(data.html);
            });
        }

        let cartTimeout;

        function updateTiket(ticketId, jumlah) {
            clearTimeout(cartTimeout);

            cartTimeout = setTimeout(() => {
                $.ajax({
                    url: "{{ route('tickets.createCart') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        ticket_id: ticketId,
                        quantity: jumlah
                    },
                    beforeSend: function() {
                        $('#cart-container').addClass('opacity-50 pointer-events-none');
                    },
                    success: function(res) {
                        console.log('Session:', res);
                        refreshCart();
                        $('#cart-container').html(
                            '<div class="p-14 "><h1 class="text-center text-xs md:text-sm font-semibold text-gray-600">Memuat tiket....</h1></div>'
                        );
                    },
                    complete: function() {
                        $('#cart-container').removeClass('opacity-50 pointer-events-none');
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    },
                });
            }, 400);
        }
    </script>
@endsection
