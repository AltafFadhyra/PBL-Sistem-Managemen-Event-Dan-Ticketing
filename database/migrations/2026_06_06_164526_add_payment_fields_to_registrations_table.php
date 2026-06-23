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
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('payment_proof')->nullable()->after('status');
        });

        \Illuminate\Support\Facades\DB::statement("ALTER TABLE registrations MODIFY COLUMN status VARCHAR(255) DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn('payment_proof');
        });
        
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE registrations MODIFY COLUMN status ENUM('registered') DEFAULT 'registered'");
    }
};
