<?php

namespace App\Console\Commands;

use App\Helpers\iCal;
use App\Models\Back\Apartment\Apartment;
use App\Models\Back\Orders\Order;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SyncCalendar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:calendar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync apartments Booking & Airbnb calendars.';

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
        $apartments = Apartment::select('id', 'links')->get();

        if ($apartments->count()) {
            $start = microtime(true);

            foreach ($apartments as $apartment) {
                $links = json_decode($apartment->links, true);

                if ($links && ! empty($links)) {
                    foreach ($links as $key => $link) {
                        $time = Carbon::now();
                        $from = Carbon::create($time->year, $time->month, $time->day, 21, 59, 0);
                        $to = Carbon::create($time->year, $time->month, $time->day, 23, 59, 0);

                        if ($time->between($from, $to, true) && $key == 'airbnb') {
                            //...
                        } else {
                            if (isset($link['link']) && $link['link']) {
                                $request = new Request([
                                    'apartment' => $apartment->id,
                                    'target' => $key,
                                    'url' => $link['link'],
                                ]);

                                $apartment->syncUrlWith($request);
                            }
                        }
                    }
                }
            }

            $end = microtime(true);
            Log::info('__Sync:Calendars - Total Execution Time: ' . number_format(($end - $start), 2, ',', '.') . ' sec.');
        }

        return 1;
    }
}
