<?php


namespace App\Repositories;


use App\Repositories\Interfaces\CarsRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CarsRepository implements CarsRepositoryInterface
{

    public function countOfAll()
    {
        return DB::table('cars')
            ->select(DB::raw('count(*) as cars_count'))
            ->get()[0]->cars_count;
    }


    public function countOfClientCars(int $client_id)
    {
        return DB::table('cars')
            ->where('owner', '=', $client_id)
            ->select(DB::raw('count(*) as cars_count'))
            ->get()[0]->cars_count;
    }


    public function placedCars()
    {
        return DB::table('cars')
            ->where('cars.places', '=', true)
            ->get();
    }
}
