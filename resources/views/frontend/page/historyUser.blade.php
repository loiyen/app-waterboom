@extends('frontend.layout.main')

@section('container')
    @include('frontend.partial.navbar')

    <div class="container mx-auto max-w-6xl mt-28 md:mt-36 mb-10 px-4">
        <div class="mb-5">
            <div class="text-start mb-4 flex justify-start text-gray-700">
                <a href="/">
                    <h1 class="hover:text-blue-700 hover:underline text-xs cursor-pointer">
                        Beranda
                    </h1>
                </a>
                <a href="{{ route('history.buy') }}">
                    <h1 class="text-xs font-semibold hover:text-blue-700 hover:underline">
                        <i class="fa fa-angle-right text-gray-400 px-2"></i> Riwayat
                    </h1>
                </a>
            </div>
        </div>
        <div class="mb-5">
            <h1 class="text-2xl md:text-3xl py-3 md:px-1 text-start font-bold text-gray-700">
                <b class="text-blue-700">Riwayat</b>
            </h1>
            <div class="flex justify-between md:justify-start md:gap-2 text-xs mb-4">
                <button class="filter-btn border py-2 px-4 md:px-6 rounded-md hover:bg-blue-700 hover:font-semibold hover:text-white" data-status="all">
                    Semua
                </button>
                <button class="filter-btn border py-2 px-3 md:px-6 rounded-md hover:bg-blue-700 hover:font-semibold hover:text-white"
                    data-status="unpaid">
                    Belum Bayar
                </button>
                <button class="filter-btn border py-2 px-2 md:px-6 rounded-md hover:bg-blue-700 hover:font-semibold hover:text-white"
                    data-status="paid">
                    Selesai
                </button>
                <button class="filter-btn border py-2 px-2 md:px-6 rounded-md hover:bg-blue-700 hover:font-semibold hover:text-white"
                    data-status="expired">
                    Kadaluarsa
                </button>
            </div>
        </div>

        <div id="history-container">
            @include('frontend.page.partial.history_list', ['history' => $history])
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.filter-btn').on('click', function() {
                let status = $(this).data('status');
                let container = $('#history-container');

                container.html('<p class="text-center text-sm text-gray-500 p-16">Memuat data...</p>');

                $.ajax({
                    url: "{{ route('history.filter') }}",
                    type: "GET",
                    data: {
                        status: status
                    },
                    success: function(response) {
                        container.html(response);
                    },
                    error: function() {
                        container.html(
                            '<p class="text-center text-red-500 py-4">Gagal memuat data</p>'
                        );
                    }
                });
            });
        });
    </script>
@endsection
