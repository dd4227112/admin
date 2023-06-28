<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OptimizePayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Payment optimization for each student ';

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
        $student_id = DB::table('shulesoft.store_students_id')->where('status', 0)->first()->student_id;
    //temporary hard-coded for motherofmercy schema_name
    if(DB::SELECT("SELECT * FROM shulesoft.redistribute_student_payments($student_id, 'motherofmercy')")){
        $update = ['status' =>1];
        DB::table('shulesoft.store_students_id')->where('student_id', $student_id)->update($update);
        Log::error("Payment optimization succes for student with student_id ".$student_id);
    }
        return 0;
    }
}
