<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientPersonalDataPostRequest;
use App\Models\Car;
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
                'first_name' => 'required|string|max:50|min:3',
                'second_name' => 'required|string|max:50|min:3',
                'third_name' => 'string|max:50|nullable',
                'gender' => 'integer|between:0,1',
                'phone' => 'string|size:11|unique:clients,phone',
                'address' => 'string|max:255|nullable'
            ],
            $customErrorMessages,
            $attributes
        );

        //Валидация данных о машинах

        //Сообщения об ошибках
        $customErrorMessages_Cars = [
            'required' => 'Поле :attribute обязательно для заполнения.',
            'between:0,1' => 'Поле :attribute должно иметь значение от 0 до 1000000 символов.',
            'max' => 'Максимальная длина поля :attribute дожна быть не больше :max.',
            'integer' => 'Поле :attribute должно быть числом.',
            'unique' => 'Данный :attribute уже зарегистрирован в системе.',
            'string' => 'Поле :attribute должно быть строкой.',
            'size' => 'Поле :attribute должно иметь длину :size.'
        ];

        //Русификация атрибутов
        $attributes_Cars = [
            'brand' => 'марка',
            'model' => 'модель',
            'color' => 'цвет',
            'license_plate' => 'гос. номер РФ',
        ];

        $validator_Cars = array(); //Массив ошибок для машин
        $car_data_matches_arr = array(); //Список групп машин с повторяющимися гос. номерами

        //Валидация каждой машины
        foreach ($request->cars as $index => $car){
            //Валидации данных о машине
            $validator_car_tmp = Validator::make(
                $car,
                [
                    'brand' => 'required|string|max:50',
                    'model' => 'required|string|max:50',
                    'color' => 'string|max:50',
                    'license_plate' => 'string|size:6|unique:cars,license_plate',
                ],
                $customErrorMessages_Cars,
                $attributes_Cars
            );

            //Если данные текущей машины неверны
            if( !empty($validator_car_tmp->fails()) )
                $validator_Cars[$index] = $validator_car_tmp->messages();

            $car_data_matches = 0; //Количество поторяющихся гос. номеров
            $not_in_data_matches_arr = true; //Флаг отсутствия в массиве дубликатов

            //Проверить на присутствие текущего элемента в массиве дубликатов
            foreach ($car_data_matches_arr as $data_matches_group){
                //Не найдено дубликата
                if( in_array($index, $data_matches_group) ){
                    $not_in_data_matches_arr = false;
                    break;
                }
            }

            //Текущий гос. номер не числится в дубликатах
            if($not_in_data_matches_arr){

                $data_matches_group_tmp = array(); //Заготовка для новой группы дубликатов

                //Проверка на совпадении гос. номеров в пришедших данных о машинах
                foreach ($request->cars as $index_compared => $car_compared){
                    //Найден будликат
                    if($index != $index_compared && $car['license_plate'] != null && $car['license_plate'] ==  $car_compared['license_plate']){
                        $car_data_matches++;
                        $data_matches_group_tmp[] = $index_compared; //Добавление в заготовку дубликатов
                    }
                }

                //Если в заготовке присутствуюз записи о дубликатах
                if( $car_data_matches > 0 ){
                    $data_matches_group_tmp[] = $index; //Добавляем проверяемую изначально машину
                    $car_data_matches_arr[] = $data_matches_group_tmp; //Добавляем собранную группу в массив с групами дубликатов
                }
            }
        }


        //Возвращение ответа об ошибке
        if ( !empty($validator->fails()) || !empty($validator_Cars) || !empty($car_data_matches_arr)) {

            if(!empty($validator->fails())){
                $errors['client'] = $validator->messages();
            }

            if(!empty($validator_Cars)){
                $errors['cars'] = $validator_Cars;
            }

            if( !empty($car_data_matches_arr) ){
                $errors['cars_duplicate_groups'] = $car_data_matches_arr;
            }

            return response()->json([
                'success' => false,
                'errors' => $errors
            ]);
        }

        $client_data = $request;

        $client_data['first_name'] = addslashes(htmlspecialchars($request->first_name));
        $client_data['second_name'] = addslashes(htmlspecialchars($request->second_name));
        $client_data['third_name'] = addslashes(htmlspecialchars($request->third_name));
        $client_data['gender'] = (int)$request->gender;
        $client_data['phone'] = addslashes(htmlspecialchars($request->phone));
        $client_data['address'] = addslashes(htmlspecialchars($request->address));

        $client = new Client();

        $client_data_response = $client->createClient($client_data);

        if(!json_decode($client_data_response->original['success'])){
            return $client_data_response;
        }

        $cars_response = [];

        //Создание машин и привязка ее к клиенту
        foreach ($request->cars as $index => $car){
            $car_data = $car;
            $car_data['brand'] = addslashes(htmlspecialchars($car['brand']));
            $car_data['model'] = addslashes(htmlspecialchars($car['model']));
            $car_data['color'] = addslashes(htmlspecialchars($car['color']));
            $car_data['license_plate'] = addslashes(htmlspecialchars($car['license_plate']));
            $car_data['owner'] = json_decode($client_data_response->original['data'])->client_id;

            $car_model = new Car();
            $car_model->createCar($car_data);
        }

        return $client_data_response;
    }
}
