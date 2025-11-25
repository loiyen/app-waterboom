<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-base.png') }}">
    @vite(['resources/css/app.css'])

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .swiper-wrapper {
            width: 100%;
            height: max-content !important;
            padding-bottom: 64px !important;
            -webkit-transition-timing-function: linear !important;
            transition-timing-function: linear !important;
            position: relative;
        }

        .swiper-pagination-bullet {
            background: #4f46e5;
        }
    </style>
</head>

<body class="font-poppins" style="overflow-x: hidden">


    <div id="loading" class="fixed inset-0 w-full h-full bg-white flex flex-col items-center justify-center z-[9999]">
        <div id="loadingAnimation" class="w-52 h-52"></div>
        <p class="mt-6 text-lg font-bold text-gray-600 tracking-wide">
            Loading...
        </p>
    </div>

    @yield('container')

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    text: '{{ session('success') }}',
                });
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "error",
                    text: '{{ session('error') }}',
                });
            });
        </script>
    @endif

    @if (session('kosong'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    text: '{{ session('kosong') }}',
                    imageUrl: '{{ asset('img/cart.png') }}', 
                    imageWidth: 120,
                    imageHeight: 120,
                    imageAlt: 'Keranjang kosong',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#2563eb', 
                    background: '#ffffff',
                    backdrop: `
                    rgba(0,0,0,0.4)
                    left top
                    no-repeat
                `,
                });
            });
        </script>
    @endif


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');

                    Swal.fire({
                        text: "Semua tiket akan dihapus ?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#111184",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, hapus!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-konfirm');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');

                    Swal.fire({
                        text: "Semua tiket akan dihapus!",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#111184",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, hapus!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-konfirm-service');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');

                    Swal.fire({
                        text: "Semua layanan akan dihapus!",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#111184",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, hapus!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>


    @vite(['resources/css/app.css', 'resources/js/app.js'])
</body>

</html>
