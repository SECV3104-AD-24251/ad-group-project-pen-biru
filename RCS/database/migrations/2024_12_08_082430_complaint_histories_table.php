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
        // Drop the table if it exists
        Schema::dropIfExists('complaint_histories');

        // Create the table with the correct columns
        Schema::create('complaint_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->constrained('complaints')->onDelete('cascade'); // Foreign key to complaint
            $table->string('status');  // Add status column
            $table->text('remarks')->nullable();  // Add remarks column (nullable)
            $table->timestamp('changed_at');  // Add changed_at column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the table if rolling back
        Schema::dropIfExists('complaint_histories');
    }
};
