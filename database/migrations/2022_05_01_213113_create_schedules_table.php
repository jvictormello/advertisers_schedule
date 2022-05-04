<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('contractor_id');
            $table->unsignedInteger('advertiser_id');
            $table->unsignedSmallInteger('status_id');
            $table->decimal('price');
            $table->date('date');
            $table->char('duration', 1);
            $table->time('start_time');
            $table->time('end_time');
            $table->string('postal_code', 8);
            $table->foreign('contractor_id')->references('id')->on('contractors');
            $table->foreign('advertiser_id')->references('id')->on('advertisers');
            $table->foreign('status_id')->references('id')->on('status');
            $table->boolean('cancelled')->default(false);
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
        Schema::dropIfExists('schedules');
    }
}
