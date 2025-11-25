<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 13px; }
        .box { border:1px solid #ccc; padding:20px; margin-bottom:20px; }
        .center { text-align:center; }
    </style>
</head>
<body>

<h2 style="text-align:center;">E-Tiket Waterboom Jogja</h2>

<div class="box">
    <p>Nama: <strong>{{ $order->customer->name }}</strong></p>
    <p>Kode Tiket: <strong>{{ $order->order_code }}</strong></p>
    <p>Tanggal Kunjungan: <strong>{{ $order->order_date }}</strong></p>
    {{-- <p>Jumlah Tiket: <strong>{{ $order->items->qty }}</strong></p> --}}
</div>

<div class="center">
    <p><strong>SCAN QR CODE UNTUK VERIFIKASI</strong></p>
   <img src="data:image/png;base64,{{ $qr }}" width="200">

</div>

<p style="margin-top:20px;">Tunjukkan e-tiket ini saat check-in.</p>

</body>
</html>
