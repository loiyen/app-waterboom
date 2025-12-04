<?php

namespace App\Services;

use App\Models\Events;
use App\Models\Galleries;

class EventService
{
    public function get_data()
    {
        $data_event = Events::where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        $data_banner = Galleries::where('category', 'acara')->get();

        return [
            'data_event'    => $data_event,
            'banner'        => $data_banner
        ];
    }

    public function get_detail($slug)
    {
        $detail_event   = Events::where('slug', $slug)->firstOrFail();
        $event_lainya = Events::where('is_active', 1)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return [
            'detail_event'       => $detail_event,
            'event'              => $event_lainya
        ];
    }

    public function getPencarian($query)
    {
        return Events::when($query, function ($qbuilder) use ($query) {
            $qbuilder->where('title', 'like', "%{$query}%");
        })
            ->latest()
            ->paginate(8);
    }
}
