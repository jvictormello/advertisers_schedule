<?php

use App\Enums\SchedulesStatus;
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
            $table->id();
            $table->integer('advertiser_id');
            $table->integer('contractor_id');
            $table->float('price', 8, 2);
            $table->string('contractor_zip_code');
            $table->string('status')->default(SchedulesStatus::Pending);
            $table->date('date');
            $table->time('starts_at');
            $table->time('finishes_at');
            $table->integer('duration');
            $table->time('started_at');
            $table->time('finished_at');
            $table->float('amount', 8, 2);
            $table->softDeletes();
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
