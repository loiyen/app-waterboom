@extends('frontend.layout.main')

@section('container')
    @include('frontend.partial.navbar')

    <div class="container mx-auto max-w-6xl mt-28 md:mt-36 mb-10 px-4">
        <div class="10">
            <div class="text-start mb-4 flex justify-start text-gray-700">
                <a href="/">
                    <h1 class="hover:text-blue-700 hover:underline text-xs cursor-pointer">
                        Beranda
                    </h1>
                </a>
                <a href="{{ route('tiket.checkout') }}">
                    <h1 class="text-xs font-semibold hover:text-blue-700 hover:underline">
                        <i class="fa fa-angle-right text-gray-400 px-2"></i> Tiket
                    </h1>
                </a>
                <a href="#">
                    <h1 class="text-xs font-semibold hover:text-blue-700 hover:underline">
                        <i class="fa fa-angle-right text-gray-400 px-2"></i> Checkout
                    </h1>
                </a>
                <h1 class="text-xs font-semibold">
                    <i class="fa fa-angle-right text-gray-400 px-2"></i>
                </h1>
            </div>
        </div>

        <div class="mb-5">
            <h1 class="text-2xl md:text-3xl py-3 md:px-1 text-start font-bold text-gray-700">
                <b class="text-blue-700">Checkout</b> Tiket
            </h1>
        </div>

        <div>
            <div class="mb-10">
                <div class="flex justify-between mb-2 items-center">
                    <h1 class="text-sm md:text-base mb-2 text-gray-700 font-semibold">
                        Informasi Pemesanan
                    </h1>
                    <form action="{{ route('destroy.cart') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="btn-konfirm text-xs md:text-base text-gray-700 border font-semibold rounded-md px-3 py-2 hover:bg-blue-700 hover:text-white"><i
                                class="fa fa-edit"></i> Ubah</button>
                    </form>

                </div>

                <div class="border bg-blue-700 text-xs md:text-sm rounded-md text-white shadow-sm py-3 px-4">
                    <div class="flex justify-between py-1">
                        <h1>Tanggal Kunjungan</h1>
                        <h1 class="font-semibold">{{ format_tanggal($date) }}</h1>
                    </div>
                    <div class="flex justify-between py-1">
                        <h1 class="">Jenis Tiket</h1>
                        <h1 class="font-semibold">{{ $ticket_category }}</h1>
                    </div>


                </div>
            </div>
            <div class="mb-0">
                <div class="mb-3">
                    <h1 class="text-sm md:text-base mb-2 text-gray-700 font-semibold">
                        Layanan lainnya
                    </h1>
                </div>
                <div class="swiper default-carousel relative mb-0">
                    <div class="swiper-wrapper gap-1">
                        @forelse ($servicesAll as $item)
                            <div class="swiper-slide">
                                <div class="border rounded-md shadow-md">
                                    <div class="flex justify-center mb-4">
                                        <img src="{{ asset('img/water2.jpg') }}"
                                            class="w-full h-20 md:h-36 rounded-t-md object-cover" alt="">
                                    </div>
                                    <div class="px-4 mb-1 text-gray-700">
                                        <div class="flex justify-between">
                                            <h1 class="font-semibold text-sm md:text-base mb-1">{{ $item->name }}</h1>
                                            <div class="text-sm md:text-sm">
                                                @if ($item->is_active == 1)
                                                    <h1 class="text-green-500 font-semibold  mb-1">Tersedia</h1>
                                                @else
                                                    <h1 class="text-red-700 font-semibold  mb-1">Habis</h1>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <h1 class="text-gray-700 text-sm md:text-sm">
                                                Kapasitas : <span class="font-semibold">{{ $item->description }}</span>
                                            </h1>
                                        </div>
                                        <h1 class="text-sm text-gray-700 mb-3">
                                            <span class="font-semibold text-sm">Rp{{ number_format($item->price) }}</span>
                                        </h1>
                                    </div>
                                    <form class="form-service" method="POST">
                                        @csrf
                                        <div class="flex flex-col md:flex-row px-4 mb-4 justify-between items-center gap-3">
                                            <div class="flex items-center justify-between w-full md:w-52 gap-2 mt-2">
                                                <button type="button"
                                                    class="btn-service-kurang px-2 justify-center bg-gray-200 rounded hover:bg-blue-700 hover:text-white"
                                                    data-service-id="{{ $item->id }}">-</button>
                                                <input type="text" name="quantity" value="0" readonly
                                                    class="jumlah-service w-full text-center border rounded" />
                                                <button type="button"
                                                    class="btn-service-tambah px-2 justify-center bg-gray-200 rounded hover:bg-blue-700 hover:text-white"
                                                    data-service-id="{{ $item->id }}">+</button>
                                            </div>
                                            <div class="w-full">
                                                <button type="submit" data-service-id="{{ $item->id }}"
                                                    class="btn-add-service w-full md:w-full border items-center rounded-md hover:font-semibold hover:bg-blue-700 hover:text-white text-xs py-3 md:py-2">
                                                    Tambah
                                                </button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-4 w-full text-center text-gray-500  p-20 rounded-md bg-slate-50">
                                <div class="flex justify-center items-center mt-10 mb-5">
                                    <img src="{{ asset('img/notfon.png') }}" class="w-16" alt="">
                                </div>
                                <div class="items-center">
                                    <h1 class="font-semibold">Tidak di temukan!</h1>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

        <div class="flex flex-col  md:flex-row gap-3 mb-10">

            <div class="w-full mb-5">
                <div id="cart-container1" class="flex flex-col justify-between mt-2">
                    @include('frontend.page.partial.checkout_cart', ['tickets' => $tickets])
                </div>
            </div>

            <div class="w-full mb-5">
                <div class="mb-6 flex justify-between items-center">
                    <h1 class="text-sm md:text-base font-semibold text-gray-700">Layanan lainnya</h1>
                    <button type="button" id="btn-hapus-semua-layanan"
                        class="text-xs md:text-sm py-2 px-3 border rounded-full hover:font-semibold hover:bg-red-700 hover:text-white">
                        <i class="fa fa-trash" aria-hidden="true"></i> Hapus Semua
                    </button>
                </div>
                <div id="service-cart-container" class="mt-4">
                    @include('frontend.page.partial.service_cart', [
                        'cart_service' => $cart_service,
                        'services' => $servicesCart,
                    ])

                </div>
            </div>
        </div>
        <div id="rincian-pembayaran" class="pb-20">
            @include('frontend.page.partial.details_payment', [
                'total_price' => $total_price ?? 0,
                'total_priceService' => $total_priceService ?? 0,
            ])
        </div>
    </div>
    </div>

    <script>
        const MAX_QTY = 10;

        // === Tambah Tiket ===
        $(document).on('click', '.btn-tambah', function() {
            const card = $(this).closest('.cart-item');
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
                    title: 'Maksimal tercapai!',
                    text: `Kamu hanya bisa membeli maksimal ${MAX_QTY} tiket per jenis.`,
                    timer: 1500,
                    showConfirmButton: false,
                    position: 'top-end',
                    toast: true
                });
            }
        });
        $(document).on('click', '.btn-kurang', function() {
            const card = $(this).closest('.cart-item');
            const input = card.find('.jumlah-tiket');
            let jumlah = parseInt(input.val()) || 0;

            if (jumlah > 0) jumlah--;
            input.val(jumlah);

            const ticketId = card.data('ticket-id');
            updateTiket(ticketId, jumlah);
        });

        let cartTimeout;

        function updateTiket(ticketId, jumlah) {
            clearTimeout(cartTimeout);

            cartTimeout = setTimeout(() => {
                $.ajax({
                    url: "{{ route('cart.update') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        ticket_id: ticketId,
                        quantity: jumlah
                    },
                    beforeSend: function() {
                        $('#cart-container1').addClass(
                            'opacity-50 pointer-events-none transition duration-300');
                    },
                    success: function(res) {

                        if (res.html_cart) {
                            $('#cart-container1').html(res.html_cart);
                        }
                        if (res.html_rincian) {
                            $('#rincian-pembayaran').html(res.html_rincian);
                        }

                        if (res.total_price !== undefined) {
                            $('.total-harga').text('Rp' + parseInt(res.total_price).toLocaleString(
                                'id-ID'));
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Jumlah tiket diperbarui.',
                            position: 'top-end',
                            toast: true,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    },
                    complete: function() {
                        $('#cart-container1').removeClass('opacity-50 pointer-events-none');
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);

                        if (xhr.responseJSON && xhr.responseJSON.redirect) {
                            Swal.fire({
                                icon: 'warning',
                                text: xhr.responseJSON.error ||
                                    'Keranjang kosong! Silakan pilih tiket kembali.',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = xhr.responseJSON.redirect;
                            });
                        }
                    },
                });
            }, 300);
        }
    </script>


    <script>
        const MAX_SERVICE_QTY = 5;

        $(document).ready(function() {

            // Tombol tambah qty layanan
            $(document).on('click', '.btn-service-tambah', function(e) {
                e.preventDefault();

                const form = $(this).closest('.form-service');
                const input = form.find('.jumlah-service');
                let qty = parseInt(input.val()) || 0;

                if (qty < MAX_SERVICE_QTY) {
                    input.val(qty + 1).addClass('ring ring-blue-300');
                    setTimeout(() => input.removeClass('ring ring-blue-300'), 300);
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Maksimal tercapai!',
                        text: `Kamu hanya bisa menambah maksimal ${MAX_SERVICE_QTY} layanan per jenis.`,
                        timer: 1500,
                        showConfirmButton: false,
                        position: 'top-end',
                        toast: true
                    });
                }
            });

            $(document).on('click', '.btn-service-kurang', function(e) {
                e.preventDefault();
                const form = $(this).closest('.form-service');
                const input = form.find('.jumlah-service');
                let qty = parseInt(input.val()) || 0;
                if (qty > 0) input.val(qty - 1);
            });

            // Submit form layanan
            $(document).on('submit', '.form-service', function(e) {
                e.preventDefault();

                const form = $(this);
                const serviceId = form.find('.btn-add-service').data('service-id');
                const quantity = parseInt(form.find('.jumlah-service').val()) || 0;

                if (quantity <= 0) {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Jumlah harus lebih dari 0.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    return;
                }

                $.ajax({
                    url: "{{ route('add.service') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        service_id: serviceId,
                        quantity: quantity
                    },
                    beforeSend: function() {
                        form.find('button').prop('disabled', true);
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            text: response.message,
                            position: 'top-end',
                            toast: true,
                            timer: 1200,
                            showConfirmButton: false
                        });
                        if (response.html_cart) {
                            $('#service-cart-container').html(response.html_cart);
                        }

                        if (response.html_rincian) {
                            $('#rincian-pembayaran').html(response.html_rincian);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        let message = 'Terjadi kesalahan.';

                        if (xhr.responseJSON?.error) {
                            message = xhr.responseJSON.error;
                        } else if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            message = Object.values(errors).flat().join('\n');
                        }

                        Swal.fire({
                            icon: 'error',
                            text: message,
                            confirmButtonText: 'OK'
                        });
                    },
                    complete: function() {
                        form.find('button').prop('disabled', false);
                    }
                });
            });

        });
    </script>

    <script>
        $(document).on('submit', '.form-delete-service', function(e) {
            e.preventDefault();

            const serviceId = $(this).data('service-id');

            $.ajax({
                url: `/checkout-ticket/service/${serviceId}`, // pastikan route-nya sama
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {

                    $('#service-cart-container').html(response.html_cart);

                    $('#rincian-pembayaran').html(response.html_rincian);

                    Swal.fire({
                        icon: 'success',
                        text: 'Layanan dihapus',
                        position: 'top-end',
                        toast: true,
                        timer: 1500,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: xhr.responseJSON?.error ||
                            'Terjadi kesalahan saat menghapus layanan.',
                    });
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '#btn-hapus-semua-layanan', function() {
            Swal.fire({
                title: 'Hapus semua layanan?',
                text: 'Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#111184",
                cancelButtonColor: "#d33",
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('destroy.service') }}",
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        beforeSend: function() {
                            $('#btn-hapus-semua-layanan').prop('disabled', true);
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });

                            $('#service-cart-container').html(
                                '<div class="flex justify-center mb-6"><img src="{{ asset('img/cart.png') }}" class="object-cover w-20 h-20" alt=""></div>'
                            );

                            $('#rincian-pembayaran').load(location.href +
                                " #rincian-pembayaran > *");
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                text: xhr.responseJSON?.error ||
                                    'Gagal menghapus layanan.',
                            });
                        },
                        complete: function() {
                            $('#btn-hapus-semua-layanan').prop('disabled', false);
                        }
                    });
                }
            });
        });
    </script>
@endsection
