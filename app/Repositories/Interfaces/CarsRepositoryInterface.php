<?php


namespace App\Repositories\Interfaces;


use phpDocumentor\Reflection\Types\Integer;

interface CarsRepositoryInterface
{
    /**
     * Получение количества автомобилей в бд
     *
     * @return integer
     */
    public function countOfAll();


    /**
     * Получение количества автомобилей клиента в бд
     *
     * @param int $client_id
     *
     * @return integer
     */
    public function countOfClientCars(int $client_id);
}
