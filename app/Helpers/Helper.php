<?php

namespace App\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Helper
{

    /**
     * @param Collection $calendars
     *
     * @return Collection
     */
    public static function getCalendarBackViewData(Collection $calendars): Collection
    {
        $response = [];
        $count = 0;

        foreach ($calendars->groupBy('apartment_id') as $group) {
            $color = '#' . config('settings.calendar_colors')[$count];

            foreach ($group as $calendar) {
                $response[] = [
                    'title' => $calendar->apartment->title,
                    'start' => $calendar->date_from,
                    'end'   => $calendar->date_to,
                    'color' => $color
                ];
            }

            $count++;
        }



        return collect($response);
    }


    /**
     * @return array
     */
    public static function getActivePaymentCodes()
    {
        return collect(config('settings.payment.providers'))->keys()->toArray();
    }


    /**
     * @param float $price
     * @param int   $discount
     * @param bool  $extra
     *
     * @return float
     */
    public static function calculateDiscountPrice(float $price, int $discount, bool $extra = false)
    {
        if ($extra) {
            return $price + ($price * ($discount / 100));
        }

        return $price - ($price * ($discount / 100));
    }


    /**
     * @param string $tag
     *
     * @return \Illuminate\Cache\TaggedCache|mixed|object
     */
    public static function resolveCache(string $tag): ?object
    {
        if (env('APP_ENV') == 'local') {
            return Cache::getFacadeRoot();
        }

        return Cache::tags([$tag]);
    }

}
