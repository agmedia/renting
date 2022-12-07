<?php

namespace App\Helpers;

use App\Models\Back\Apartment\Apartment;
use App\Models\Back\Marketing\Action\Action;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ActionHelper
{

    /**
     * @var bool
     */
    private static $extra = false;


    /**
     * @param $date_start
     * @param $date_end
     *
     * @return bool
     */
    public static function isActiveByDates($date_start, $date_end, $day = null): bool
    {
        if ( ! $date_start && ! $date_end) {
            return true;
        }

        $start = ! $date_start; // Same as ...( ! $date_start) ? true : false;
        $end   = ! $date_end;
        $now   = ! $day ? now() : Carbon::make($day);

        if ($date_start && $date_start <= $now) {
            $start = true;
        }

        if ($date_end && $date_end > $now) {
            $end = true;
        }

        if ($start && $end) {
            return true;
        }

        return false;
    }


    /**
     * @return int
     */
    public static function runSetupCron(): int
    {
        $log_start = microtime(true);

        $actions = Action::query()->select('id', 'date_start', 'date_end', 'status')->get();
        // Prvo setati akcije prema datumu, jesu status 1 ili 0.
        foreach ($actions as $action) {
            $start = $action->date_start ? Carbon::make($action->date_start) : null;
            $end   = $action->date_end ? Carbon::make($action->date_end) : null;

            if (ActionHelper::isActiveByDates($start, $end)) {
                $action->update(['status' => 1]);
            } else {
                $action->update(['status' => 0]);
            }
        }

        // Delete all actions on apartments.
        Apartment::query()->update(['action_id' => 0]);

        $actions = Action::query()->select('id', 'group', 'links', 'status')
                         ->where('status', 1)
                         ->get();
        // Prvo setati gdje su svi apartmani odabrani.
        foreach ($actions as $action) {
            if ($action->group == 'all') {
                Apartment::query()->update(['action_id' => $action->id]);
            }
        }
        // Onda setati individualne apartmane.
        foreach ($actions as $action) {
            if ($action->group == 'apartment') {
                Apartment::query()->whereIn('id', json_decode($action->links))->update(
                    ['action_id' => $action->id]
                );
            }
        }

        $log_end = microtime(true);
        Log::info('__Set:Actions - Total Execution Time: ' . number_format(($log_end - $log_start), 2, ',', '.') . ' sec.');

        return 1;
    }


    /**
     * @param Action $action
     * @param array  $reservation_days
     *
     * @return array
     */
    public static function resolveCheckoutData(\App\Models\Front\Catalog\Action $action, array $reservation_days, \App\Models\Front\Apartment\Apartment $apartment): array
    {
        $days = [];
        $prices = [];

        foreach ($reservation_days as $reservation_day) {
            if (static::isActiveByDates($action->date_start, $action->date_end, $reservation_day)) {
                array_push($days, $reservation_day);
                array_push($prices, static::resolvePrice($action, $apartment, $reservation_day));
            }
        }

        return [
            'action' => $action->toArray(),
            'extra' => static::$extra,
            'days' => $days,
            'prices' => $prices
        ];
    }


    /**
     * @param \App\Models\Front\Catalog\Action      $action
     * @param \App\Models\Front\Apartment\Apartment $apartment
     * @param string                                $day
     *
     * @return float|mixed
     */
    public static function resolvePrice(\App\Models\Front\Catalog\Action $action, \App\Models\Front\Apartment\Apartment $apartment, string $day)
    {
        if ($action->type == 'F') {
            if (Helper::isWeekend($day)) {
                if ($action->price_weekends > $apartment->price_weekends) {
                    static::$extra = true;
                }

                return $action->price_weekends - $apartment->price_weekends;
            }

            if ($action->price_regular > $apartment->price_regular) {
                static::$extra = true;
            }

            return $action->price_regular - $apartment->price_regular;
        }

        if (Helper::isWeekend($day)) {
            if ($action->discount) {
                return Helper::calculateDiscountPrice($apartment->price_weekends, $action->discount);
            }

            static::$extra = true;

            return Helper::calculateDiscountPrice($apartment->price_weekends, $action->extra, true);
        }

        if ($action->discount) {
            return Helper::calculateDiscountPrice($apartment->price_regular, $action->discount);
        }

        static::$extra = true;

        return Helper::calculateDiscountPrice($apartment->price_regular, $action->extra, true);
    }


}
