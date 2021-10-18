<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Database\Seeders\SpaceshipTableSeeder;

class AddSpaceships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        (new SpaceshipTableSeeder())->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('spaceships')->where([
            ['name', 'Cheetoh'],
            ['description', 'They are intelligent with the ability to learn quickly']
        ])->delete();

        DB::table('spaceships')->where([
            ['name', 'Bengal'],
            ['description', 'Extremely intelligent, curious and active']
        ])->delete();
    }
}
