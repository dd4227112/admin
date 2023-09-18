<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class missingPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'missing:payments';

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
       //find all school that migrated from old version to new version
        // $schemas =DB::select("select distinct username from admin.clients where is_new_version =1 and status =1 and username  !='rightwayschools' and username in (select  DISTINCT table_schema from information_schema.tables where table_type ='BASE TABLE' and table_schema != 'public' )");
        // foreach ($schemas as $key => $schema) { 
            DB::statement("select shulesoft.transfermissingpayment('kilimanischools')");
        // }
        
        return 0;
    }
}
