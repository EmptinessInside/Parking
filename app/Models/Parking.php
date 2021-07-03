<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Parking extends Model
{
    use HasFactory;

    public function placeCar($car_id){

        return DB::table('cars')
            ->where('id', '=', $car_id)
            ->update([
                'placed' => true
            ]);
    }

    public function replaceCar($car_id){

        return DB::table('cars')
            ->where('id', '=', $car_id)
            ->update([
                'placed' => false
            ]);
    }
}
