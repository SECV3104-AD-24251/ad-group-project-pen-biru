<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConditionAuditTable extends Migration
{
    public function up()
    {
        Schema::create('condition_audit', function (Blueprint $table) {
            $table->id();
            $table->string('room'); // Room name (e.g., MPK1)
            $table->string('resource'); // Resource (e.g., PC 1, Projector)
            $table->enum('condition', ['USABLE', 'UNUSABLE'])->default('USABLE'); // Resource condition
            $table->timestamps(); // Created and updated timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('condition_audit');
    }
}
