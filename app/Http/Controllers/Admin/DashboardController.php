<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEvents = Event::count();
        $totalPendaftar = Registration::count();
        $pendingPayments = Registration::where('status', 'pending')->count();
        
        $recentRegistrations = Registration::with('event', 'ticketType')
            ->latest()
            ->take(5)
            ->get();

        $totalPendapatan = Registration::where('status', 'paid')
            ->join('ticket_types', 'registrations.ticket_type_id', '=', 'ticket_types.id')
            ->sum('ticket_types.price');

        $totalPanitia = User::count();

        return view('dashboard', compact(
            'totalEvents',
            'totalPendaftar',
            'pendingPayments',
            'recentRegistrations',
            'totalPendapatan',
            'totalPanitia'
        ));
    }
}
