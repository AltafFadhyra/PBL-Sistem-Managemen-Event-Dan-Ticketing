<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show(Registration $registration)
    {
        if ($registration->status !== 'pending') {
            return redirect()->route('registrations.show', $registration->registration_number);
        }

        $registration->load('event', 'ticketType');
        return view('frontend.checkout.show', compact('registration'));
    }

    public function store(Request $request, Registration $registration)
    {
        if ($registration->status !== 'pending') {
            return redirect()->route('registrations.show', $registration->registration_number);
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($registration->payment_proof && \Illuminate\Support\Facades\Storage::disk('public')->exists($registration->payment_proof)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($registration->payment_proof);
        }

        $path = $request->file('payment_proof')->store('payments', 'public');
        
        $registration->update([
            'payment_proof' => $path,
            'status' => 'pending', // tetap pending sampai admin approve
        ]);

        return redirect()->route('registrations.show', $registration->registration_number)
            ->with('success', 'Bukti pembayaran berhasil diunggah. Kami akan segera memverifikasi pembayaran Anda.');
    }

    public function destroy(Registration $registration)
    {
        if ($registration->status !== 'pending') {
            return redirect()->route('registrations.show', $registration->registration_number);
        }

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();
            
            // Kembalikan kuota tiket
            $ticketType = \App\Models\TicketType::where('id', $registration->ticket_type_id)->lockForUpdate()->first();
            if ($ticketType) {
                $ticketType->quota += 1;
                $ticketType->save();
            }

            // Hapus file bukti pembayaran jika ada
            if ($registration->payment_proof && \Illuminate\Support\Facades\Storage::disk('public')->exists($registration->payment_proof)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($registration->payment_proof);
            }

            $registration->delete();

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('home')->with('success', 'Pendaftaran Anda berhasil dibatalkan.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat membatalkan pendaftaran.');
        }
    }
}
