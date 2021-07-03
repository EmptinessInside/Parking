<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use Illuminate\Http\Request;

class ParkingController extends Controller
{
    public function placeClientCar(Request $request){

        $success = true;
        $data = null;
        $errors = null;

        $client_id = (int)$request->client_id;
        $car_id = (int)$request->car_id;

        $parking = new Parking();

        $parking->placeCar($car_id);

        return response()->json([
            'success' => $success,
            'data' => $data,
            'errors' => $errors
        ]);
    }

    public function replaceClientCar(Request $request){

        $success = true;
        $data = null;
        $errors = null;

        $client_id = (int)$request->client_id;
        $car_id = (int)$request->car_id;

        $parking = new Parking();

        $parking->replaceCar($car_id);

        return response()->json([
            'success' => $success,
            'data' => $data,
            'errors' => $errors
        ]);
    }
}
