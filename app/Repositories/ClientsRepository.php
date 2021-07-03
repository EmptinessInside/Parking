<?php

namespace App\Repositories;

use App\Client;
use App\Car;
use App\Repositories\Interfaces\ClientsRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ClientsRepository implements ClientsRepositoryInterface
{

    public function all()
    {
        return DB::table('clients')
            ->rightJoin('cars', 'clients.id', '=', 'cars.owner')
            ->select(
                'clients.*',
                'cars.brand as brand',
                'cars.model as model',
                'cars.license_plate as license_plate',
                'cars.owner as owner',
                'cars.id as car_id',
                'cars.placed as placed'
            )
            ->orderBy('cars.placed', 'asc')
            ->get();
    }

    public function allInBounds(int $offset, int $limit)
    {
        return DB::table('clients')
            ->rightJoin('cars', 'clients.id', '=', 'cars.owner')
            ->select(
                'clients.*',
                'cars.brand as brand',
                'cars.model as model',
                'cars.license_plate as license_plate',
                'cars.id as car_id',
                'cars.placed as placed'
            )
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    public function allClients(){
        return DB::table('clients')
            ->get();
    }

}
