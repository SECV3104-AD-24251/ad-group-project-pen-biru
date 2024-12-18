<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('resource_details', function (Blueprint $table) {
            $table->id();
            $table->string('resource_type'); // Projector, Chair, Table, etc.
            $table->string('detail');        // Problem details (e.g., Broken leg, Screen issue)
            $table->integer('severity')->comment('Severity level from 1 to 3'); // Severity level
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('resource_details');
    }
}
