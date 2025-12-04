<?php

if (!function_exists('format_tanggal_indo')) {
    /**
     * Format tanggal ke format Indonesia: 19 Oktober 2025
     * @param string $tanggal format "YYYY-MM-DD"
     * @return string
     */
    function format_tanggal($tanggal)
    {
        $bulanIndo = [
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        $tgl = strtotime($tanggal);
        $d = date('j', $tgl);
        $m = date('n', $tgl);
        $y = date('Y', $tgl);
       

        return $d . ' ' . $bulanIndo[$m] . ' ' . $y . ' ';
    }

    function format_jam($jam)
    {
        $jam = strtotime($jam);
        return date('H:i', $jam);
    }

    function format_tanggal_jam($tanggal)
{
    $bulanIndo = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    $tgl = strtotime($tanggal);
    $d = date('j', $tgl);
    $m = date('n', $tgl);
    $y = date('Y', $tgl);
    $jam = date('H:i', $tgl); // format 24 jam (contoh: 14:35)

    return $d . ' ' . $bulanIndo[$m] . ' ' . $y . ' - ' . $jam . ' WIB';
}

}
