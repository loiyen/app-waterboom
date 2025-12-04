<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $eventservice;

    public function __construct(EventService $eventservice)
    {
        return $this->eventservice = $eventservice;
    }

    public function index()
    {
        $data_event = $this->eventservice->get_data();

        return view('frontend.page.eventPage', [
            'title'             => 'Acara || Waterboom jogja',
            'data_event'        => $data_event['data_event'],
            'banner'            => $data_event['banner']
        ]);
    }

    public function Detail($slug)
    {
        $event = $this->eventservice->get_detail($slug);

        return view('frontend.page.eventPageDetail', [
            'title'             => 'Detail || Waterboom jogja',
            'data_event'        => $event['detail_event'],
            'event_lain'        => $event['event']
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'nullable|string|max:100'
        ]);

        $query = trim($request->q ?? '');


        $data_event = $this->eventservice->getPencarian($query);

        return view('frontend.page.partial.event_list', [
            'data_event' => $data_event
        ]);
    }
}
