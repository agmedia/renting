<?php

namespace App\Console\Commands;

use App\Models\Back\Apartment\Apartment;
use Illuminate\Console\Command;

class SetApartmentFeaturedAmenities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:apartment-featured-amenities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set featured amenities on apartments for list view.';

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
        foreach (Apartment::pluck('id') as $id) {
            (new Apartment())->resolveFeaturedAmenities($id);
        }

        return 1;
    }
}
