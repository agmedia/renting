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
     * @param        $dateFromString
     * @param        $dateToString
     * @param string $day
     *
     * @return array
     * @throws \Exception
     */
    public static function getDaysInRange(string $from_date, string $to_date, string $day) {
        $dateFrom = new\ DateTime($from_date);
        $dateTo = new\ DateTime($to_date);
        $dates = [];

        if ($dateFrom > $dateTo) {
            return $dates;
        }

        if (1 != $dateFrom->format('N')) {
            $dateFrom->modify('next ' . $day);
        }

        while ($dateFrom <= $dateTo) {
            $dates[] = $dateFrom->format('Y-m-d');
            $dateFrom->modify('+1 week');
        }

        return $dates;
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


    /**
     * @return array
     */
    public static function getValidOrderStatuses(): array
    {
        return [
            config('settings.order.status.new'),
            config('settings.order.status.pending'),
            config('settings.order.status.paid')
        ];
    }

}
