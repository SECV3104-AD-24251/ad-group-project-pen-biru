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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('block_name');
            $table->string('room');
            $table->string('resource_type');
            $table->string('details')->nullable(); // Add nullable to avoid errors
            $table->integer('severity')->nullable(); // Severity might be optional
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('priority_level')->nullable(); 
            $table->string('priority')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps(); // Adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
