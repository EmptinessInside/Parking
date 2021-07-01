<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Car extends Model
{
    use HasFactory;

    public function createCar($car_data){
        $success = true;
        $response_data = null;
        $errors = null;

        try{
            $id = DB::table('cars')->insertGetId([
                'brand' => $car_data['brand'],
                'model' => $car_data['model'],
                'color' => $car_data['color'],
                'license_plate' => $car_data['license_plate'],
                'owner' => (int)$car_data['owner'],
            ]);
        }
        catch (QueryException){
            //Ошибка запроса
            $success = false;
            $errors = [
                'query' => 'Query error!'
            ];
        }

        if($success){
            $response_data = json_encode( array('car_id' => $id) );
        }

        return response()->json([
            'success' => $success,
            'data' => $response_data,
            'errors' => $errors,
        ]);
    }
}
