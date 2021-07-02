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


}
