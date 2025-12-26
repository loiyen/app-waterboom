<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Services\AboutService;
use App\Services\BerandaService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    protected $berandaService;
    protected $aboutService;

    public function __construct(BerandaService $berandaService, AboutService $aboutService)
    {
        $this->berandaService = $berandaService;
        $this->aboutService = $aboutService;
    }

    public function index()
    {
        $data_partner = $this->berandaService->getData();
        $data_waterboom = $this->aboutService->get_data();

        return view('frontend.page.aboutUsPage', [
            'title'                 => 'Tentang Kami || Waterboom Jogja',
            'partner'               => $data_partner['partner'],
            'waterboom'             => $data_waterboom['waterboom'],
            'visi'                  => $data_waterboom['visi'],
            'misi'                  => $data_waterboom['misi'],
            'feature'               => $data_waterboom['feature'],
        ]);
    }

    public function careers()
    {
        $data_loker = $this->aboutService->get_data_loker();

        $data_banner = $this->aboutService->get_banner();

        return view('frontend.page.aboutCareersPage', [
            'title'             => 'Karir || Waterboom Jogja',
            'data_loker'        =>  $data_loker,
            'banner'       => $data_banner
        ]);
    }

    public function careers_detail($slug)
    {
        $detail_loker   = $this->aboutService->detail_data_loker($slug);

        return view('frontend.page.aboutCareersDetail', [
            'title'         => 'Detail loker || Waterboom Jogja',
            'detail_loker'        => $detail_loker['data_loker']
        ]);
    }
}
