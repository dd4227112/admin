<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Customer;


class CreateTodayReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'today:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a daily report';

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
        if(date('H:i') =='14:50'){ 
            (new Customer())->createTodayReport();
        }
        return 0;
    }
}
