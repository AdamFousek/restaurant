<?php

declare(strict_types=1);


namespace App\Repositories\Enum;

enum ReservationOrderByEnum: string
{
    case ORDER_BY_ID = 'id';
    case ORDER_BY_RESERVATION_DATETIME = 'reservation_datetime';
    case ORDER_BY_NUMBER_OF_TABLES = 'number_of_tables';
    case ORDER_BY_CREATED_AT = 'created_at';
}
