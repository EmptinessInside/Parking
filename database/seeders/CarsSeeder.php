<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    }

    public function createCar($owner){
        DB::table('cars')->insert([
            'brand' => Str::random(10),
            'model' => Str::random(10),
            'color' => Str::random(10),
            'license_plate' => Str::random(6),
            'owner' => $owner
        ]);
    }
}
