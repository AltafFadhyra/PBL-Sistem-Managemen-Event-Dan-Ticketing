<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;

class EventController extends Controller
{
    public function show($slug)
    {
        $event = Event::where('slug', $slug)->with(['categories', 'ticketTypes' => function($q) {
            $q->where('quota', '>', 0);
        }])->firstOrFail();

        return view('frontend.events.show', compact('event'));
    }
}
