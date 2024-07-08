<?php

declare(strict_types=1);


namespace App\Services;

use App\Queries\Reservation\GetTableReservationByDateHandler;
use App\Queries\Reservation\GetTableReservationByDateQuery;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class ReservationService
{
    private const string CACHE_PREFIX = 'reservation_table_';

    public function __construct(
        private readonly GetTableReservationByDateHandler $getTableReservationByDateHandler,
    )
    {
    }

    /**
     * @param Carbon $from
     * @param Carbon $to
     * @return array{
     *      markers: array {
     *          date: string,
     *          type: string,
     *          tooltip: array {
     *              text: string,
     *              color: string,
     *          }[],
     *      }[],
     *      days: array{
     *          day: string,
     *          isAvailable: bool,
     *      }[],
     * }
     */
    public function resolveDays(Carbon $from, Carbon $to): array
    {
        $result = [
            'markers' => [],
            'days' => [],
        ];
        $totalTables = config('restaurant.max_tables', 0);

        do {
            $isAvailable = true;
            $tables = $this->getFromCache($from);
            if ($tables === null) {
                $tables = $this->getTableReservationByDateHandler->handle(new GetTableReservationByDateQuery(
                    $from
                ));
            }

            if ($tables === $totalTables) {
                $isAvailable = false;
                // Marker created for fronted https://vue3datepicker.com/props/general-configuration/#markers
                $marker = [
                    'date' => $from->toISOString(),
                    'type' => 'line',
                    'tooltip' => [
                        ['text' => 'This day is full', 'color' => 'red'],
                    ],
                ];

                $result['markers'][] = $marker;
            }

            $this->setCache($from, $tables);


            $result['days'][] = [
                'day' => $from->toISOString(),
                'isAvailable' => $isAvailable,
            ];

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
