<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\TicketType;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'visitor_name' => 'required|string|max:255',
            'visitor_email' => 'required|email|max:255',
            'visitor_phone' => ['required', 'string', 'max:20', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
        ]);

        try {
            DB::beginTransaction();

            // Cek pendaftaran ganda (1 email hanya 1 kali di 1 event) secara atomik
            $exists = Registration::where('event_id', $event->id)
                ->where('visitor_email', $request->visitor_email)
                ->lockForUpdate() // Tambahkan lock agar baris ini konsisten di dalam transaksi
                ->exists();

            if ($exists) {
                DB::rollBack();
                return back()->with('error', 'Email ini sudah terdaftar untuk event ini.')->withInput();
            }

            // Pessimistic Locking pada kuota tiket
            $ticketType = TicketType::where('id', $request->ticket_type_id)
                ->where('event_id', $event->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($ticketType->quota <= 0) {
                DB::rollBack();
                return back()->with('error', 'Maaf, kuota tiket ini sudah habis.')->withInput();
            }

            // Kurangi kuota
            $ticketType->quota -= 1;
            $ticketType->save();

            // Buat pendaftaran
            $registrationNumber = 'EVT-' . date('Y') . '-' . strtoupper(str()->random(6));
            $status = $ticketType->price > 0 ? 'pending' : 'paid';

            $registration = Registration::create([
                'ticket_type_id' => $ticketType->id,
                'event_id' => $event->id,
                'registration_number' => $registrationNumber,
                'visitor_name' => $request->visitor_name,
                'visitor_email' => $request->visitor_email,
                'visitor_phone' => $request->visitor_phone,
                'status' => $status,
            ]);

            DB::commit();

            if ($status === 'pending') {
                return redirect()->route('checkout.show', $registration->registration_number)
                    ->with('success', 'Pendaftaran berhasil! Silakan selesaikan pembayaran.');
            }

            return redirect()->route('registrations.show', $registration->registration_number)
                ->with('success', 'Pendaftaran berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem saat mendaftar. Silakan coba lagi.');
        }
    }

    public function show(Registration $registration)
    {
        if ($registration->status === 'pending') {
            return redirect()->route('checkout.show', $registration->registration_number);
        }

        $registration->load('event', 'ticketType');
        return view('frontend.registrations.show', compact('registration'));
    }
}
