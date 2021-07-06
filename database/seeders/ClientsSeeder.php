<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $carSeeder = new CarsSeeder();

        for ( $i = 0; $i<10; $i++){
            DB::table('clients')->insert([
                'first_name' => Str::random(10),
                'second_name' => Str::random(10),
                'third_name' => Str::random(10),
                'gender' => rand(0, 1),
                'phone' => '7999234' . rand( 1000, 9999),
                'address' => Str::random(111),
            ]);

            for($j = 0; $j < rand(1,5); $j++){
                $carSeeder->createCar($i+1);
            }
        }
    }
}
