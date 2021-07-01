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
}
