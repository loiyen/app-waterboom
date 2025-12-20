<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Services\EventService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

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
        $query = $request->validate([
            'q' => 'nullable|string|max:100'
        ])['q'] ?? '';

        $query = strip_tags(trim($query));

        try {
            $data_event = $this->eventservice->getPencarian($query);

            return response(
                view('frontend.page.partial.event_list', compact('data_event'))->render()
            )
                ->header('Cache-Control', 'no-store')
                ->header('X-Content-Type-Options', 'nosniff');
        } catch (\Throwable $e) {
            Log::error('Event search error', ['error' => $e->getMessage()]);
            return response('', 500);
        }
    }
}
