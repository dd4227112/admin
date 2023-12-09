<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class transferMissing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:missing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer missing data into shulesoft schema';

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
        DB::SELECT("SELECT * FROM shulesoft.transfer_missing_data_into_shulesoft('stpeterclaver')");
        DB::table('admin.track_transfer')->insert(['schema_name'=>'stpeterclaver', 'status' =>1]);
        return 0;
    }
}
