<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('timetable_slots', function (Blueprint $table) {
        $table->id();
        $table->string('room_name'); // Room identifier
        $table->date('date'); // Date of the slot
        $table->enum('slot', ['morning', 'evening']); // Morning or Evening slot
        $table->string('description')->nullable(); // Maintenance description
        $table->enum('status', ['available', 'booked'])->default('available'); // Slot status
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetable_slots');
    }
};
