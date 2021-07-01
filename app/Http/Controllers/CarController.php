<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CarsRepositoryInterface;
use Illuminate\Http\Request;

class CarController extends Controller
{
    private $carsRepository;

    public function __construct(CarsRepositoryInterface $carsRepository){
        $this->carsRepository = $carsRepository;
    }

    public function carsCount(){

        $errors = null;

        return response()->json([
            'success' => true,
            'cars_count' => $this->carsRepository->countOfAll(),
            'errors' => $errors
        ]);
    }
}
