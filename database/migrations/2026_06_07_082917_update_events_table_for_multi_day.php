<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // $table->dropForeign(['event_category_id']);
            $table->dropColumn('event_category_id');
            $table->renameColumn('date', 'start_date');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dateTime('end_date')->nullable()->after('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('event_category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->renameColumn('start_date', 'date');
            $table->dropColumn('end_date');
        });
    }
};
