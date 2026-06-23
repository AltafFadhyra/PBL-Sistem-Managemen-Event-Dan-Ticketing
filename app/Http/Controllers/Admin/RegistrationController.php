<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function approve(Registration $registration)
    {
        if ($registration->status === 'paid') {
            return back()->with('info', 'Pembayaran ini sudah berstatus paid.');
        }

        // Jika sebelumnya direject (kuota sudah terlanjur dikembalikan), maka tarik lagi kuotanya
        if ($registration->status === 'rejected') {
            $ticket = $registration->ticketType;
            if ($ticket->quota <= 0) {
                return back()->with('error', 'Tidak dapat menyetujui ulang pendaftaran ini karena kuota tiket sudah habis.');
            }
            $ticket->decrement('quota');
        }

        $registration->update(['status' => 'paid']);
        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function reject(Registration $registration)
    {
        if ($registration->status === 'rejected') {
            return back()->with('info', 'Pembayaran ini sudah berstatus ditolak.');
        }

        $registration->update(['status' => 'rejected']);
        
        // Kembalikan kuota tiket
        $ticket = $registration->ticketType;
        $ticket->increment('quota');

        return back()->with('success', 'Pembayaran ditolak dan kuota dikembalikan.');
    }
}
