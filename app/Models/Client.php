<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    use HasFactory;

    /**
     * Создание нового клиента
     *
     * @param  object  $client_data
     *
     * @return object
     */
    public function createClient($client_data){
        $success = true;
        $response_data = null;
        $errors = null;

        try{
            $id = DB::table('clients')->insertGetId([
                'first_name' => $client_data->first_name,
                'second_name' => $client_data->second_name,
                'third_name' => $client_data->third_name,
                'gender' => $client_data->gender,
                'phone' => $client_data->phone,
                'address' => $client_data->address
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
            $response_data = json_encode( array('client_id' => $id) );
        }

        return response()->json([
           'success' => $success,
           'data' => $response_data,
           'errors' => $errors,
        ]);
    }

    /**
     * Получение клиента по его id
     *
     * @param  int  $client_id
     *
     * @return object
     */
    public function getClientById(int $client_id){

        $client = DB::table('clients')
            ->where('clients.id', '=', $client_id)
            ->select(
                'first_name',
                'second_name',
                'third_name',
                'gender',
                'phone',
                'address',
                'id'
            )
            ->limit(1)
            ->get();

        return count($client) ? $client[0] : null;
    }

    /**
     * Получение машин клиента
     *
     * @param  int  $client_id
     *
     * @return object
     */
    public function getClientCars(int $client_id){

        return DB::table('cars')
            ->where('cars.owner', '=', $client_id)
            ->select(
                'brand',
                'model',
                'color',
                'license_plate',
                'id'
            )
            ->get();
    }

    /**
     * Обновление клиента
     *
     * @param  int  $client_id
     *
     * @return object
     */
    public function updateClient($client_data){
        $success = true;
        $response_data = null;
        $errors = null;

        try{
            DB::table('clients')
                ->where('clients.id','=',(int)$client_data->id)
                ->update([
                'first_name' => $client_data->first_name,
                'second_name' => $client_data->second_name,
                'third_name' => $client_data->third_name,
                'gender' => $client_data->gender,
                'phone' => $client_data->phone,
                'address' => $client_data->address
            ]);
        }
        catch (QueryException){
            //Ошибка запроса
            $success = false;
            $errors = [
                'query' => 'Query error!'
            ];
        }

        return response()->json([
            'success' => $success,
            'data' => $response_data,
            'errors' => $errors,
        ]);
    }

    public function updateClientCars($cars, $client_id){

        $success = true;
        $response_data = null;
        $errors = null;

        DB::table('cars')
            ->where('owner', '=', $client_id)
            ->delete();

        foreach ($cars as $car) {
            DB::table('cars')
                ->insert([
                    'brand' => $car['brand'],
                    'model' => $car['model'],
                    'color' => $car['color'],
                    'license_plate' => $car['license_plate'],
                    'owner' => $client_id
                ]);
        }

        return response()->json([
            'success' => $success,
            'data' => $response_data,
            'errors' => $errors,
        ]);
    }

    public function removeClient($client_id){
        $success = true;
        $response_data = null;
        $errors = null;

        DB::table('clients')
            ->where('id', '=', $client_id)
            ->delete();

        return response()->json([
            'success' => $success,
            'data' => $response_data,
            'errors' => $errors,
        ]);
    }
}
