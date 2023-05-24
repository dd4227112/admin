<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use \App\Models\ConstantPermissionGroup;

class InsertData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert data in database';

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
        $permission =new ConstantPermissionGroup;
        $permission->name ='Unyama';
        $permission->save();
    //     DB::table('shulesoft.sms')->insert(
    //     ['body'=>'testing',
    //     'user_id'=>1,
    //     'schema_name'=>'stpeterclaver'
    //     ]

    //    );
    Log::info('Data inserted');
        return 0;
    }
}
