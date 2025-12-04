<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            text-align: center;
            padding: 80px 20px;
        }

        .code {
            font-size: 120px;
            font-weight: 600;
            color: #3b82f6;
        }

        .message {
            font-size: 20px;
            margin-top: 10px;
            color: #475569;
        }

        a {
            margin-top: 20px;
            display: inline-block;
            background: #3b82f6;
            padding: 12px 25px;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            transition: .3s;
        }

        a:hover {
            background: #1d4ed8;
        }
    </style>
</head>

<body>

    <div class="code">404</div>
    <div class="message">Oops! Halaman yang kamu cari tidak ditemukan.</div>
    <a href="{{ url('/') }}">Kembali ke Beranda</a>

</body>

</html>
