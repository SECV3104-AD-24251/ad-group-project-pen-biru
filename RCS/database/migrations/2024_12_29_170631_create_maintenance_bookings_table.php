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
        Schema::create('maintenance_bookings', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time');
            $table->string('task');
            $table->timestamps();
            $table->string('block_name')->nullable();
            $table->string('room')->nullable();
            $table->string('priority')->nullable();
            $table->string('booking_status')->default('pending'); // Use descriptive column name
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_bookings');
        Schema::table('maintenance_bookings', function (Blueprint $table) {
            $table->dropColumn(['block_name', 'room', 'priority']);
        });
    }
};
