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
        // TODO: Implement all() method.
    }

    public function allInBounds(int $offset, int $limit)
    {
        return DB::table('clients')
            ->rightJoin('cars', 'clients.id', '=', 'cars.owner')
            ->select(
                'clients.*',
                'cars.brand as brand',
                'cars.model as cars.model',
                'cars.license_plate as license_plate',
                'cars.id as car_id'
            )
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

}
