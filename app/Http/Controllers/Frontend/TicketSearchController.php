<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;

class TicketSearchController extends Controller
{
    public function index()
    {
        return view('frontend.tickets.search');
    }

    public function find(Request $request)
    {
        $request->validate([
            'visitor_email' => 'required|email',
            'visitor_phone' => 'required|string',
        ], [
            'visitor_email.required' => 'Email wajib diisi.',
            'visitor_phone.required' => 'Nomor WhatsApp wajib diisi.',
        ]);

        $registrations = Registration::with(['event', 'ticketType'])
            ->where('visitor_email', $request->visitor_email)
            ->where('visitor_phone', $request->visitor_phone)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($registrations->isEmpty()) {
            return back()->with('error', 'Tiket tidak ditemukan. Pastikan Email dan Nomor WhatsApp yang dimasukkan sama dengan saat pendaftaran.')->withInput();
        }

        if ($registrations->count() === 1) {
            return redirect()->route('registrations.show', $registrations->first()->registration_number)
                ->with('success', 'Tiket Anda berhasil ditemukan!');
        }

        return view('frontend.tickets.results', compact('registrations', 'request'));
    }
}
