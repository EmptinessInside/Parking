<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Repositories\Interfaces\CarsRepositoryInterface;
use App\Models\Client;
use Illuminate\Http\Request;

class CarController extends Controller
{
    private $carsRepository;

    public function __construct(CarsRepositoryInterface $carsRepository){
        $this->carsRepository = $carsRepository;
    }

    public function cars_count(){

        $errors = null;

        return response()->json([
            'success' => true,
            'cars_count' => $this->carsRepository->countOfAll(),
            'errors' => $errors
        ]);
    }

    public function showPlaced(){
        $errors = null;

        return response()->json([
            'success' => true,
            'data' => $this->carsRepository->placedCars(),
            'errors' => $errors
        ]);
    }

    public function remove(Request $request){

        $success = true;
        $response_data = null;
        $errors = null;

        $car_id = (int)$request->car_id;
        $client_id = (int)$request->client_id;

        $car = new Car();
        $car->removeCar($car_id);

        $cars_count = $this->carsRepository->countOfClientCars($client_id);

        if($cars_count == 0 ){
            $client = new Client();
            $client->removeClient($client_id);
        }

        return response()->json([
            'success' => $success,
            'data' => $this->carsRepository->countOfAll(),
            'errors' => $errors
        ]);
    }
}
