<?php

namespace App\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

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

        foreach ($calendars as $calendar) {
            $response[] = [
                'title' => $calendar->apartment->title,
                'start' => $calendar->date_from,
                'end' => $calendar->date_to
            ];
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
     *
     * @return float|int
     */
    public static function calculateDiscountPrice(float $price, int $discount)
    {
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
