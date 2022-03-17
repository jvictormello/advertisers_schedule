<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'title' => 'Blusa Jupiter',
            'price' => 79.90,
            'quantity' => 10,
            'image_url' => 'https://picsum.photos/200/300?grayscale',
        ]);

        DB::table('products')->insert([
            'title' => 'Calça Netuno',
            'price' => 39.90,
            'quantity' => 10,
            'image_url' => 'https://picsum.photos/200/300?grayscale',
        ]);

        DB::table('products')->insert([
            'title' => 'Casaco Terra',
            'price' => 109.90,
            'quantity' => 10,
            'image_url' => 'https://picsum.photos/200/300?grayscale',
        ]);

        DB::table('products')->insert([
            'title' => 'Blusa Marte',
            'price' => 19.90,
            'quantity' => 10,
            'image_url' => 'https://picsum.photos/200/300?grayscale',
        ]);

        DB::table('products')->insert([
            'title' => 'Calça Mercúrio',
            'price' => 199.90,
            'quantity' => 10,
            'image_url' => 'https://picsum.photos/200/300?grayscale',
        ]);

        DB::table('products')->insert([
            'title' => 'Casaco Urano',
            'price' => 149.90,
            'quantity' => 10,
            'image_url' => 'https://picsum.photos/200/300?grayscale',
        ]);
    }
}
