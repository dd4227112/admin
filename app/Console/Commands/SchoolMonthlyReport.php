<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Background;

class SchoolMonthlyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schoolmontly:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a School Report';

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
        if (date('d H:i') =='28 06:36'){
         (new Background())->schoolMonthlyReport();
        }
        return 0;
    }
}
