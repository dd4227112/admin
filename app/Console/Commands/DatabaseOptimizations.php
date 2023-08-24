<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DatabaseOptimizations extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        return 0;
    }

    public function optimizeSchoolPayments() {
        $clients = DB::table('admin.clients')->where('status', 1)->where('is_new_version', 0)->get();
        foreach ($clients as $client) {
            if ($client->is_new_version == 1) {
                DB::SELECT('SELECT * FROM shulesoft.redistribute_all_student_payments(' . $client->username . ')');
            } else {
                DB::SELECT('SELECT * FROM ' . $client->username . '.redistribute_all_student_payments()');
            }
        }
    }

    public function manualVacuum() {
        
    }

}
