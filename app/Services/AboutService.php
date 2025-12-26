<?php

namespace App\Services;

use App\Models\Abouts;
use App\Models\Careers;
use App\Models\Galleries;

class AboutService
{
    public function get_data()
    {
        $waterboom  = Abouts::where('sub_content', 'waterboom')->first();
        $visi       = Abouts::where('sub_content', 'visi')->first();
        $misi       = Abouts::where('sub_content', 'misi')->first();
        $feature    = Abouts::where('sub_content', 'feature')->first();

        return [
            'waterboom'     => $waterboom,
            'visi'          => $visi,
            'misi'          => $misi,
            'feature'       => $feature
        ];
    }

    public function get_data_loker()
    {
        return Careers::latest()->get();
    }

    public function get_banner()
    {
        $banner = Galleries::where('category', 'tiket')->where('is_active', 1)->get();

        return [
            'banner' => $banner
        ];
    }

    public function detail_data_loker($slug)
    {
        $data = Careers::where('slug', $slug)->firstOrFail();

        return [
            'data_loker'        => $data
        ];
    }
}
