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
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'superadmin') DEFAULT 'admin'");
        \Illuminate\Support\Facades\DB::statement("UPDATE users SET role = 'superadmin' WHERE email = 'admin@event.com'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("UPDATE users SET role = 'admin' WHERE role = 'superadmin'");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin') DEFAULT 'admin'");
    }
};
