<?php

namespace App\Helpers;

use App\Models\Back\Apartment\Apartment;
use App\Models\Back\Marketing\Action\Action;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

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
        $now   = now();

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

}
