<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BlockNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('block_numbers', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('schdule_id');
        $table->foreign('schdule_id')->references('id')->on('schedules');
        $table->unsignedBigInteger('block_number');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('block_numbers');
    }
}
