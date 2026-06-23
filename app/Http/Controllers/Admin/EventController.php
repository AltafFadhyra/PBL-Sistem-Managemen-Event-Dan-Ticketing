<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Event::with('categories', 'ticketTypes', 'posters')->latest();

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

        $events = $query->paginate(15)->withQueryString();
        $categories = EventCategory::all();

        return view('admin.events.index', compact('events', 'categories'));
    }

    public function create()
    {
        $categories = EventCategory::all();
        return view('admin.events.create', compact('categories'));
    }

    private function compressImage($file)
    {
        if (!extension_loaded('gd')) {
            return $file->store('posters', 'public');
        }

        $info = getimagesize($file->getPathname());
        if (!$info) return $file->store('posters', 'public');

        $mime = $info['mime'];
        $image = null;

        switch ($mime) {
            case 'image/jpeg': $image = imagecreatefromjpeg($file->getPathname()); break;
            case 'image/png': $image = imagecreatefrompng($file->getPathname()); break;
            case 'image/gif': $image = imagecreatefromgif($file->getPathname()); break;
            default: return $file->store('posters', 'public');
        }

        if (!$image) return $file->store('posters', 'public');

        $filename = uniqid() . '.jpg';
        $path = 'posters/' . $filename;
        $fullPath = storage_path('app/public/' . $path);

        // Pastikan direktori ada
        if (!file_exists(storage_path('app/public/posters'))) {
            mkdir(storage_path('app/public/posters'), 0755, true);
        }

        // Simpan sebagai JPEG dengan kualitas 75%
        imagejpeg($image, $fullPath, 75);
        imagedestroy($image);

        return $path;
    }

    public function store(Request $request)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*' => 'exists:event_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:events',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
            'posters' => 'nullable|array',
            'posters.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except(['posters', 'categories']);
        
        $event = Event::create($data);
        $event->categories()->sync($request->categories);

        if ($request->hasFile('posters')) {
            foreach ($request->file('posters') as $file) {
                $path = $this->compressImage($file);
                $event->posters()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function show(Event $event)
    {
        $event->load('categories', 'ticketTypes', 'posters');
        
        $registrations = $event->registrations()->with('ticketType')->latest()->paginate(50);
        
        return view('admin.events.show', compact('event', 'registrations'));
    }

    public function edit(Event $event)
    {
        $event->load('posters');
        $categories = EventCategory::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*' => 'exists:event_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:events,slug,' . $event->id,
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
            'posters' => 'nullable|array',
            'posters.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except(['posters', 'categories']);

        $event->update($data);
        $event->categories()->sync($request->categories);

        if ($request->hasFile('posters')) {
            foreach ($request->file('posters') as $file) {
                $path = $this->compressImage($file);
                $event->posters()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus.');
    }

    public function destroyPoster(\App\Models\EventPoster $poster)
    {
        if (Storage::disk('public')->exists($poster->image_path)) {
            Storage::disk('public')->delete($poster->image_path);
        }
        $poster->delete();
        return back()->with('success', 'Poster berhasil dihapus.');
    }
}
