<?php

namespace App\Helpers;

use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
                    'color' => $color,
                    'order' => $calendar->toArray(),
                    'order_options' => unserialize($calendar->options)
                ];
            }

            $count++;

            if ($count >= count(config('settings.calendar_colors'))) {
                $count = 0;
            }
        }

        return collect($response);
    }


    /**
     * @param string      $from_date
     * @param string      $to_date
     * @param string|null $day
     *
     * @return array
     * @throws \Exception
     */
    public static function getDaysInRange(string $from_date, string $to_date, string $day = null): array
    {
        $dates = [];

        if ($day) {
            $dateFrom = new\ DateTime($from_date);
            $dateTo = new\ DateTime($to_date);

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
            //
        } else {
            $range = CarbonPeriod::create($from_date, $to_date);

            foreach ($range as $date) {
                $dates[] = $date->format('Y-m-d');
            }

            array_pop($dates);
        }

        return $dates;
    }


    /**
     * @param string $from_date
     * @param string $to_date
     * @param string $day
     *
     * @return array
     */
    public static function getWeekends(string $from_date, string $to_date, string $day): array
    {
        $dates = [];
        $function = 'is' . Str::title($day);

        $range = CarbonPeriod::create($from_date, Carbon::make($to_date)->subDay());

        foreach ($range as $date) {
            if ($date->{$function}()) {
                $dates[] = $date->format('Y-m-d');
            }
        }

        return $dates;
    }


    /**
     * @param $date
     *             Can be string in '0000-00-00' format.
     *             Or could be Carbon::date.
     *
     * @return bool
     */
    public static function isWeekend($date = null): bool
    {
        $now = now();

        if ($date && is_string($date)) {
            $now = Carbon::make($date);
        }

        if ($date && ! is_string($date)) {
            $now = $date;
        }

        if ($now->isFriday() || $now->isSaturday()) {
            return true;
        }

        return false;
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
     * @param $list_price
     * @param $seling_price
     *
     * @return float|int
     */
    public static function calculateDiscount(float $list_price, float $seling_price)
    {
        return 100 - ((($list_price - $seling_price) / $list_price) * 100);
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


    /**
     * @param string $from
     * @param string $to
     *
     * @return string[]
     */
    public static function setSessionDates(string $from, string $to): array
    {
        return [
            'from' => $from,
            'to'   => $to
        ];
    }


    public static function encryptor(string $string, string $action = 'encrypt')
    {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        //pls set your unique hashing key
        $secret_key = config('app.name');
        $secret_iv = config('mail.admin');

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        //do the encyption given text/string/number
        if( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = substr(base64_encode($output), 0, -1);
        }
        else if( $action == 'decrypt' ){
            //decrypt the given text/string/number
            $output = openssl_decrypt(base64_decode($string . '='), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

}
