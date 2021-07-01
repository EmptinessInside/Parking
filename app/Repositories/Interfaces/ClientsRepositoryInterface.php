<?php


namespace App\Repositories\Interfaces;

interface ClientsRepositoryInterface
{
    /**
     * Получение полного списка клиентов
     *
     * @return array
     */
    public function all();

    /**
     * Получение списка клиентов в границах
     *
     * @param  int  $from
     * @param  int  $to
     *
     * @return array
     */
    public function allInBounds(int $offset, int $limit);
}
