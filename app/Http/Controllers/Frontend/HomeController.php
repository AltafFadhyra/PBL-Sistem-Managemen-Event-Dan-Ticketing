<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['categories', 'posters'])->latest();

        if ($request->filled('category')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('date')) {
            $query->where(function($q) use ($request) {
                $q->whereDate('start_date', '<=', $request->date)
                  ->where(function($q2) use ($request) {
                      $q2->whereDate('end_date', '>=', $request->date)
                         ->orWhereNull('end_date');
                  });
            });
        }

        $events = $query->paginate(12)->withQueryString();
        $categories = \App\Models\EventCategory::all();
        
        return view('frontend.home', compact('events', 'categories'));
    }
}
