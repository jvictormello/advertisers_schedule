<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('availabilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('advertiser_id');
            $table->char('week_day', 1);
            $table->time('start_time');
            $table->time('end_time');
            $table->foreign('advertiser_id')->references('id')->on('advertisers');
            $table->timestamps();
            $table->unique(['advertiser_id', 'week_day'], 'advertiser_week_day');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('availabilities');
    }
}
