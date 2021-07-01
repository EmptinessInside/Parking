<?php


namespace App\Repositories\Interfaces;


interface CarsRepositoryInterface
{
    /**
     * Получение количества автомобилей в бд
     *
     * @return integer
     */
    public function countOfAll();
}
