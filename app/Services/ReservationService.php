<?php

declare(strict_types=1);


namespace App\Services;

use App\Queries\Reservation\GetTableReservationByDateHandler;
use App\Queries\Reservation\GetTableReservationByDateQuery;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class ReservationService
{
    private const string CACHE_PREFIX = 'reservation_table_';

    public function __construct(
        private readonly GetTableReservationByDateHandler $getTableReservationByDateHandler,
    ) {
    }

    /**
     * @param Carbon $from
     * @param Carbon $to
     * @return array{
     *     day: string,
     *     availableTables: integer,
     * }[]
     */
    public function resolveDays(Carbon $from, Carbon $to): array
    {
        $result = [];
        $totalTables = config('restaurant.max_tables', 0);

        do {
            $tables = $this->getFromCache($from);
            if ($tables === null) {
                $tables = $this->getTableReservationByDateHandler->handle(new GetTableReservationByDateQuery(
                    $from
                ));
            }

            $result[] = [
                'day' => $from->format('m.d.Y'),
                'dayFormatted' => $from->format('d.m.Y'),
                'availableTables' => max($totalTables - $tables, 0),
            ];

            $this->setCache($from, $tables);

            $from->addDay();
        } while ($from <= $to);

        return $result;
    }

    private function getFromCache(Carbon $date): ?int
    {
        $value = Cache::get(self::CACHE_PREFIX . $date->format('d.m.Y'));
        return $value !== null ? (int)$value : null;
    }

    private function setCache(Carbon $date, int $count): void
    {
        Cache::put(self::CACHE_PREFIX . $date->format('d.m.Y'), $count, now()->addDay());
    }

    public function pruneCache(Carbon $date): void
    {
        Cache::forget(self::CACHE_PREFIX . $date->format('d.m.Y'));
    }
}
