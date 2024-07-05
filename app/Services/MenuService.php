<?php

declare(strict_types=1);


namespace App\Services;

use Illuminate\Support\Carbon;

class MenuService
{

    /**
     * @param Carbon|null $date
     * @return array []|array{
     *     soup: array {
     *          name: string,
     *          content: string,
     *          price: string,
     *     },
     *     main: array {
     *          name: string,
     *          content: string,
     *          price: string,
     *     }
     * }[]
     */
    public function provideForWeek(): array
    {
        $menu = config('restaurant.menu');

        $result = [];
        $today = new Carbon();
        for ($i = 0; $i < 7; $i++) {
            $dayName = strtolower($today->dayName);

            $result[] = [
                'menu' => $menu[$dayName] ?? [],
                'date' => $today->format('j.n.Y'),
                'dayName' => $today->dayName,
            ];

            $today->addDay();
        }

        return $result;
    }
}
