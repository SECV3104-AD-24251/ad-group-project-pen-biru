<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbacksTable extends Migration
{
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->tinyInteger('resource_availability')->unsigned();
            $table->tinyInteger('resource_quality')->unsigned();
            $table->tinyInteger('ease_of_reporting')->unsigned();
            $table->tinyInteger('ease_of_use')->unsigned();
            $table->tinyInteger('response_time')->unsigned();
            $table->tinyInteger('clarity_of_process')->unsigned();
            $table->tinyInteger('overall_experience')->unsigned();
            $table->text('suggestions')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
}

