<?php

namespace App\Console\Commands;

use App\Helpers\ActionHelper;
use Illuminate\Console\Command;

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
        return ActionHelper::runSetupCron();
    }

}
