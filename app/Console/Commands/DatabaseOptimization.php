<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class DatabaseOptimization extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Database Optimization';

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
        if(date('H:i') =='00:40'){  
            $clients = DB::table('admin.clients')->where('status', 1)->where('is_new_version', 0)->get();
            foreach ($clients as $client) {
                if ($client->is_new_version == 1) {
                    DB::SELECT('SELECT * FROM shulesoft.redistribute_all_student_payments(' . $client->username . ')');
                } else {
                    DB::SELECT('SELECT * FROM ' . $client->username . ' redistribute_all_student_payments()');
                }
            }
        }
        return 0;
    }
}
