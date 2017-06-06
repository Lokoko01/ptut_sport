<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('timeSlot_id')->unsigned();
            $table->foreign('timeSlot_id')->references('id')->on('timeSlots');
            $table->integer('sport_id')->unsigned();
            $table->foreign('sport_id')->references('id')->on('sports');
            $table->integer('professor_id')->unsigned();
            $table->foreign('professor_id')->references('id')->on('professors');
            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')->references('id')->on('locations');
            $table->integer('max_seat');
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
        Schema::dropIfExists('sessions');
    }
}
