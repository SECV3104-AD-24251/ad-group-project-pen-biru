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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('block_name');
            $table->string('room');
            $table->string('resource_type');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('priority_level')->nullable(); // Added priority_level here
            $table->timestamps();
            $table->string('priority')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            //$table->date('date');
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('complaints');
    }
};
