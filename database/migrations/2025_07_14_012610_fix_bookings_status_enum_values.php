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
        // First, update any existing 'approved' values to 'confirmed'
        DB::table('bookings')->where('status', 'approved')->update(['status' => 'confirmed']);
        
        // Then, update any existing 'rejected' values to 'cancelled'
        DB::table('bookings')->where('status', 'rejected')->update(['status' => 'cancelled']);
        
        // Now modify the enum to include the correct values
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to the original enum values
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'");
        
        // Update values back
        DB::table('bookings')->where('status', 'confirmed')->update(['status' => 'approved']);
        DB::table('bookings')->where('status', 'cancelled')->update(['status' => 'rejected']);
    }
};
