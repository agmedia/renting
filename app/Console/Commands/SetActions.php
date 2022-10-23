<?php

namespace App\Console\Commands;

use App\Helpers\ActionHelper;
use App\Models\Back\Apartment\Apartment;
use App\Models\Back\Marketing\Action\Action;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SetActions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:actions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and set all actions on apartments.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $start = microtime(true);

        $actions = Action::query()->select('id', 'date_start', 'date_end', 'status')
                         ->where('status', 1)
                         ->get();
        // Prvo setati akcije prema datumu, jesu status 1 ili 0.
        foreach ($actions as $action) {
            $start = $action->date_start ? Carbon::make($action->date_start) : null;
            $end = $action->date_end ? Carbon::make($action->date_end) : null;

            if (ActionHelper::isActiveByDates($start, $end)) {
                $action->update(['status' => 1]);
            } else {
                $action->update(['status' => 0]);
            }
        }

        // Delete all actions on apartments.
        Apartment::query()->update(['action_id' => 0]);

        $actions = Action::query()->select('id', 'date_start', 'date_end', 'status')
                         ->where('status', 1)
                         ->get();
        // Prvo setati gdje su svi apartmani odabrani.
        foreach ($actions as $action) {
            if ($action->group == 'all') {
                Apartment::update(['action_id' => $action->id]);
            }
        }
        // Onda setati individualne apartmane.
        foreach ($actions as $action) {
            if ($action->group == 'apartment') {
                Apartment::whereIn('id', json_decode($action->links))->update(
                    ['action_id' => $action->id]
                );
            }
        }

        sleep(5);

        $end = microtime(true);
        Log::info('__Set:Actions - Total Execution Time: ' . number_format(($end - $start), 2, ',', '.') . ' sec.');

        return 1;
    }

}
