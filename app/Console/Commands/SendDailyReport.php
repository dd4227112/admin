<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class SendDailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the daily report';

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
    //    DB::table('shulesoft.sms')->insert(
    //     ['body'=>'Tunajaribu',
    //     'user_id'=>1,
    //     'schema_name'=>'stpeterclaver'
    //     ]

    //    );
       Log::info('Testing');
       return 0;
    }
}




