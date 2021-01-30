<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Faker library has been deprecated.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            'sku' => 8576409375,
            'name' => 'Dumbbell-1',
            'price' => 1.00,
            'image' => 'dumbbell-1.jpg',
            'discount' => 10,
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque deserunt, reiciendis labore et consequuntur blanditiis optio repellat.',
        ]);

        DB::table('items')->insert([
            'sku' => 9485763210,
            'name' => 'Dumbbell-2',
            'price' => 2.00,
            'image' => 'dumbbell-2.JPG',
            'discount' => 10,
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque deserunt, reiciendis labore et consequuntur blanditiis optio repellat.',
        ]);
        DB::table('items')->insert([
            'sku' => 8575846345,
            'name' => 'Dumbbell-3',
            'price' => 3.00,
            'image' => 'dumbbell-3.jpg',
            'discount' => 10,
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque deserunt, reiciendis labore et consequuntur blanditiis optio repellat.',
        ]);

    }
}
