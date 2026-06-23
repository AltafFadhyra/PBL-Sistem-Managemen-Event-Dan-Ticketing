<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'start_date', 'end_date', 'location'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function categories()
    {
        return $this->belongsToMany(EventCategory::class, 'event_event_category');
    }

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function posters()
    {
        return $this->hasMany(EventPoster::class);
    }

    protected static function booted()
    {
        static::deleting(function ($event) {
            foreach ($event->posters as $poster) {
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($poster->image_path)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($poster->image_path);
                }
            }
        });
    }
}
