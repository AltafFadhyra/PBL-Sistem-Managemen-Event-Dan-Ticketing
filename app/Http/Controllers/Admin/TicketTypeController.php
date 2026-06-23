<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\Request;

class TicketTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'valid_date' => 'nullable|date',
        ]);

        $event->ticketTypes()->create($request->all());

        return redirect()->route('admin.events.show', $event->id)->with('success', 'Jenis tiket berhasil ditambahkan.');
    }

    public function destroy(TicketType $ticket)
    {
        $eventId = $ticket->event_id;
        $ticket->delete();
        return redirect()->route('admin.events.show', $eventId)->with('success', 'Jenis tiket berhasil dihapus.');
    }
}
