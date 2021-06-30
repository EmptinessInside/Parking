<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientPersonalDataPostRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{

    public function store(Request $request){
        //Валидация данных пользователя

        $customErrorMessages = [
            'required' => 'Поле :attribute обязательно для заполнения.',
            'between:0,1' => 'Поле :attribute должно иметь значение от 0 до 1000000 символов.',
            'max' => 'Максимальная длина поля :attribute дожна быть не больше :max.',
            'integer' => 'Поле :attribute должно быть числом.',
            'unique' => 'Данный :attribute уже зарегистрирован в системе.',
            'string' => 'Поле :attribute должно быть строкой.',
            'size' => 'Поле :attribute должно иметь длину :size.'
        ];

        $attributes = [
            'first_name' => 'имя',
            'second_name' => 'фамилия',
            'third_name' => 'отчество',
            'gender' => 'пол',
            'phone' => 'телефон',
            'address' => 'адрес'
        ];

        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => 'required|string|max:50',
                'second_name' => 'required|string|max:50',
                'third_name' => 'string|max:50|nullable',
                'gender' => 'integer|between:0,1',
                'phone' => 'string|size:11|unique:clients,phone',
                'address' => 'string|max:255|nullable'
            ],
            $customErrorMessages,
            $attributes
        );

        //Валидация данных о машинах

        //Возвращение ответа об ошибке
        if ( !empty($validator->fails()) ) {
            $errors = $validator->messages();

            return response()->json([
                'success' => false,
                'errors' => $errors
            ]);
        }

        $client_data = $request;

        $client_data['first_name'] = strip_tags(addslashes(htmlspecialchars($request->first_name)));
        $client_data['second_name'] = strip_tags(addslashes(htmlspecialchars($request->second_name)));
        $client_data['third_name'] = strip_tags(addslashes(htmlspecialchars($request->third_name)));
        $client_data['gender'] = (int)$request->gender;
        $client_data['phone'] = strip_tags(addslashes(htmlspecialchars($request->phone)));
        $client_data['address'] = strip_tags(addslashes(htmlspecialchars($request->address)));

        $client = new Client();

        $client_data_response = $client->createClient($client_data);
        //Тут надо создать машины в цикле
        //Тут надо связать машину с человеком

        return $client_data_response;
    }
}
