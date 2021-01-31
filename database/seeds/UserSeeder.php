<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Jane Doe',
            'email' => 'jane@gmail.com',
            'tel' => 7873650098,
            'password' => Hash::make('password'),
            'address' => Str::random(15),
            'city' => Str::random(5),
            'state' => Str::random(2),
            'zip' => '00937',
        ]);
    }
}