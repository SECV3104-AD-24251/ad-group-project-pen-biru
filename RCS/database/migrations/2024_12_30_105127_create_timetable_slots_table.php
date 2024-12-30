<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetableSlotsTable extends Migration
{
    public function up()
    {
        Schema::create('timetable_slots', function (Blueprint $table) {
            $table->id();
            $table->string('room_name');
            $table->string('day');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('subject');
            $table->string('instructor');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('timetable_slots');
    }
}
