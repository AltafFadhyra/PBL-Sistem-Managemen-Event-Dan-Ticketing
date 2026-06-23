<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_posters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('image_path');
            $table->timestamps();
        });

        // Copy existing posters
        $events = DB::table('events')->whereNotNull('poster_path')->get();
        foreach($events as $event) {
            DB::table('event_posters')->insert([
                'event_id' => $event->id,
                'image_path' => $event->poster_path,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Drop old column
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('poster_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('poster_path')->nullable();
        });

        // Restore first poster
        $posters = DB::table('event_posters')->get()->groupBy('event_id');
        foreach($posters as $eventId => $eventPosters) {
            DB::table('events')->where('id', $eventId)->update(['poster_path' => $eventPosters->first()->image_path]);
        }

        Schema::dropIfExists('event_posters');
    }
};
