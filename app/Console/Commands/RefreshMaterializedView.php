<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class RefreshMaterializedView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh Materialized View ';

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
        if(date('H')=='01' || date('H')=='13'){
            DB::statement('select from admin.refresh_materialized_views()');
        }
        return 0;
    }
}
