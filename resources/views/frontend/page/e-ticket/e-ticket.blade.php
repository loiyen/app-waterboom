<h2>E-Tiket Waterboom Jogja</h2>

<p>Halo {{ $order->customer->name }},</p>

<p>Pembayaran Anda telah berhasil.</p>

<p>Berikut detail tiket Anda:</p>

<ul>
    <li>Kode Tiket: <strong>{{ $order->order_code }}</strong></li>
    <li>Tanggal Kunjungan: <strong>{{ $order->order_date }}</strong></li>
    {{-- <li>Jumlah Tiket: <strong>{{ $order->items->qty }}</strong></li> --}}
</ul>

<p>Silakan cek lampiran untuk e-tiket lengkap.</p>
