<?php

namespace App\Helpers;


class ActionHelper
{

    /**
     * @param $date_start
     * @param $date_end
     *
     * @return bool
     */
    public static function isActiveByDates($date_start, $date_end): bool
    {
        if ( ! $date_start && ! $date_end) {
            return true;
        }

        $start = ! $date_start; // Same as ...( ! $date_start) ? true : false;
        $end   = ! $date_end;
        $now = now();

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

}
