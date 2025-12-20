@extends('frontend.layout.main')

@section('container')
    @include('frontend.partial.navbar')

    <div class="container mx-auto max-w-6xl lg:mt-32 mt-16 mb-10">
        <div class="mb-5">
            <img src="{{ optional($banner->first())->image ? asset('storage/' . optional($banner->first())->image) : asset('no-image.jpg') }}" class="w-full md:h-80 object-cover" alt="" />
        </div>
        <div class="text-start px-4 flex justify-center md:justify-start text-gray-700">
            <a href="/">
                <h1 class="hover:text-blue-700 text-xs cursor-pointer">Beranda</h1>
            </a>
            <h1 class="text-xs font-semibold">
                <i class="fa fa-angle-right text-gray-400 px-2"></i> Acara
            </h1>
        </div>
    </div>

    <div class="container mx-auto max-w-6xl mb-10 px-4">
        <div class="mb-5">
            <h1 class="text-2xl md:text-3xl text-start font-bold text-gray-700">
                <span class="text-blue-700">Acara</span> Waterboom
            </h1>
        </div>
        <div class="text-sm md:text-base mb-10 text-gray-600">
            <p>Temukan informasi dan acara di waterboom jogja #PastiLebihSeru</p>
        </div>
        <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center mb-10">
            <h1 class="font-semibold text-base text-gray-700 mb-3 md:mb-0"></h1>
            <div class="relative w-full md:w-96">
                <input
                    class="w-full pl-10 pr-4 py-2 rounded-md border shadow-sm text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    id="search-input" type="text" placeholder="Masukan judul..." />
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <i class="fa fa-search"></i>
                </span>
            </div>
        </div>

        <div id="event-container">
            @include('frontend.page.partial.event_list', ['data_event' => $data_event])
        </div>

    </div>

    <script>
        $(document).ready(function() {
            let typingTimer;
            let delay = 500;
            let currentPage = 1;
            let isLoading = false;

            $('#search-input').on('keyup', function() {
                clearTimeout(typingTimer);
                let query = $(this).val().substring(0, 100);

                typingTimer = setTimeout(function() {
                    if (isLoading) return;
                    isLoading = true;

                    $.ajax({
                        url: "{{ route('event.search') }}",
                        type: 'GET',
                        data: {
                            q: query
                        },
                        beforeSend: function() {
                            $('#event-container').html(`
                        <div class="flex justify-center py-10">
                            <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500"></div>
                        </div>
                        <p class="text-center text-gray-500 mt-3">Memuat data...</p>
                    `);
                        },
                        success: function(response) {
                            $('#event-container').html(response);
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            $('#event-container').html(
                                '<p class="text-red-500 p-4">Terjadi error: ' + xhr
                                .status + '</p>'
                            );
                        },
                        complete: function() {
                            isLoading = false;
                        }

                    });
                }, delay);
            });

            // $('#load-more').on('click', function() {
            //     currentPage++;
            //     let query = $('#search-input').val();

            //     $.ajax({
            //         url: "{{ route('blog.load') }}",
            //         type: 'GET',
            //         data: {
            //             page: currentPage,
            //             q: query
            //         },
            //         beforeSend: function() {
            //             $('#load-more').text('Memuat...');
            //         },
            //         success: function(response) {
            //             if ($.trim(response) === '' || response.includes('Tidak ditemukan')) {
            //                 $('#load-more').text('Tidak ada lagi berita').prop('disabled',
            //                     true);
            //             } else {
            //                 $('#berita-container').append(response);
            //                 $('#load-more').text('Muat Lebih Banyak +');
            //             }
            //         },
            //         error: function() {
            //             $('#load-more').text('Terjadi kesalahan');
            //         }
            //     });
            // });
        });
    </script>

    @include('frontend.partial.footer')
@endsection
